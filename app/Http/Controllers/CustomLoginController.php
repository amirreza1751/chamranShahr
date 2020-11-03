<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPhoneNumberRequest;
use App\PhonenumberToken;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class CustomLoginController extends Controller
{
    public function send_otp_ajax(Request $request)
    {
        $input = $request->all();
        Log::info($request);

        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'phone_number' => 'required|regex:/^((09)[0-9\s\-\+\(\)]*)$/|min:11|max:11',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> 'شماره وارد شده صحیح نیست',
            ]);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        /** there is no account with requested phone number */
        if(empty($user)){
            return response()->json([
                'success' => false,
                'message'=> 'شماره وارد شده صحیح نیست',
            ]);
        }

        try {
            $response = app('App\Http\Controllers\API\OtpController')->send_otp($request);
        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> 'متاسفانه خطایی رخ داده است، لطفا مجددا تلاش کنید',
            ]);
        }
        if ($response->getStatusCode() != 200){
            return response()->json([
                'success' => false,
                'message'=> 'متاسفانه خطایی رخ داده است، لطفا مجددا تلاش کنید',
            ]);
        }

        return response()->json([
            'success' => true,
            'message'=> 'کد 5 رقمی با موفقیت ارسال شد',
            'phone_number'=> $request->get('phone_number'),
        ]);
    }

    public function account()
    {
        return view('auth.account');
    }

    public function password(VerifyPhoneNumberRequest $request)
    {
        $input = $request->all();

        $phonenumber_token = PhonenumberToken::where('phone_number', $input['phone_number'])->where('used','0')->latest()->first();

        /** otp has used before or does not exist */
        if (empty($phonenumber_token)){
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        /** otp code is incorrect */
        if($phonenumber_token->token != $input['otp_code']){
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        /** otp code is a one-time disposable token, so should been expire after first match */
        $phonenumber_token->used = '1';
//        $phonenumber_token->save();

        $user = User::where('phone_number', $request->phone_number)->first();

        /** there is no account with requested phone number */
        if(empty($user)){
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        return view('auth.login')
            ->with('email', $user->email)
            ->with('avatar', $user->avatar())
            ->with('full_name', $user->full_name);
    }

    public function credentials(Request $request)
    {

    }
}
