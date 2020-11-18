<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\VerifyPhoneNumberRequest;
use App\PhonenumberToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $input = $request->all();
//        return $request->phone_number;
//        $request->validate([
//            'phone_number' => 'required|regex:/(0)[0-9]{10,15}/',
//            'token' => 'required',
//        ]);

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'phone_number' => 'required|regex:/^((09)[0-9\s\-\+\(\)]*)$/|min:11|max:11',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'phone_number' => [
                        'فرمت شماره تلفن همراه صحیح نیست'
                    ],
                ],
            ], 422);
        }
        /**
         * validate token field
         */
        $validator = Validator::make($input, [
            'token' => 'required|regex:/^([0-9]{5})$/'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'token' => [
                        'کد احراز شماره تلفن همراه صحیح نیست.'
                    ],
                ],
            ], 422);
        }

        $record = PhonenumberToken::where('phone_number',$request->phone_number)->where('used','0')->latest()->first();
        if ($record == null){
            return response()->json([
                'success' => false,
                'message' => 'کد احراز شماره تلفن همراه وجود ندارد'
            ],400);
        }

        if($record->token != $request->token){
            return response()->json([
                'success' => false,
                'message' => 'کد احراز شماره تلفن همراه مجاز نیست'
            ],400);
        }

        $check_user = User::where('phone_number', $request->phone_number)->first(); /**  age user vojud dasht dg nemisazesh va mostaghim login ro seda mizane. */
        if (isset($check_user)){
//            return response()->json(['status'=>'duplicate user', 'description'=> 'already registered. please sign in.'], 200);
            $created_user = [
                'phone_number' => $check_user->phone_number,
//            'remember_me' => '1'
            ];

            $new_request = new \Illuminate\Http\Request();
            $new_request->replace($created_user);
            $login_response = app('App\Http\Controllers\API\AuthController')->login($new_request);

            $record->used = '1';
            $record->save();

            return $login_response;
        }

        $user = User::create([
            'phone_number' => $request->phone_number,
            'username' => app('App\Http\Controllers\API\AuthController')->random_username_generator(15),
//            'gender_unique_code' => 'UNKNOWN'
        ]);
        $created_user = [
            'phone_number' => $user->phone_number,
//            'remember_me' => '1'
        ];

        $new_request = new \Illuminate\Http\Request();
        $new_request->replace($created_user);
        $login_response = app('App\Http\Controllers\API\AuthController')->login($new_request);

        $record->used = '1';
        $record->save();

        return $login_response;
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $input = $request->all();

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'phone_number' => 'required|regex:/^((09)[0-9\s\-\+\(\)]*)$/|min:11|max:11',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'phone_number' => [
                        'فرمت شماره تلفن همراه صحیح نیست'
                    ]
                ],
            ], 422);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if($user == null)
            return response()->json([
                'success' => false,
                'message' => 'حساب کاربری وجود ندارد'
            ], 401);



        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(300);

        $token->save();

        return response()->json([
            'success' => true,
            'message' => 'احراز هویت موفقیت آمیز بود',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'با موفقیت خارج شدید'
        ]);
    }



    public function random_username_generator($n) {
        $characters = '123456789abcdefghijklmnopqrstuvwxyz_';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = mt_rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
