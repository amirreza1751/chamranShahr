<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPhoneNumberRequest;
use App\PhonenumberToken;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
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
            if (isset(json_decode($response->getContent())->success) && !json_decode($response->getContent())->success){
                return response()->json([
                    'success' => false,
                    'message'=> json_decode($response->getContent())->message,
                ]);
            }
        } catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> 'متاسفانه خطایی رخ داده است، لطفا مجددا تلاش کنید',
            ]);
        }

        return response()->json([
            'success' => true,
            'message'=> 'کد احراز شماره تلفن همراه با موفقیت ارسال شد',
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

        $phonenumber_token = PhonenumberToken::where('phone_number', $input['phone_number'])->where('used','0')->where('deleted_at', NULL)->latest()->first();

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
        $phonenumber_token->save();

        $user = User::where('phone_number', $request->phone_number)->first();

        /** there is no account with requested phone number */
        if(empty($user)){
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        return view('auth.login')
            ->with('phone_number', $user->phone_number)
            ->with('avatar', $user->avatar())
            ->with('full_name', $user->full_name);
    }

    public function credentials(Request $request)
    {
        $input = $request->all();
        /**
         * validate phone_number field
         */
        $validator = Validator::make($input, [
            'phone_number' => 'required|regex:/^((09)[0-9\s\-\+\(\)]*)$/|min:11|max:11',
        ]);
        if ($validator->fails()) {
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        /** there is no account with requested phone number */
        if(empty($user)){
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        $request->request->set('email', $user->email);

        try{
            return app('App\Http\Controllers\Auth\LoginController')->login($request);
        }catch (\Exception $e){
            /** if User has too many login attempts, restrict his account for 12 hours */
            if (app('App\Http\Controllers\Auth\LoginController')->checkThrottle($request)){
                Flash::error('بیش از حد مجاز رمز عبور اشتباه وارد شده است. حساب شما برای مدتی بسته شده است.');

                return redirect(route('auth.account'));
            }

            Flash::error('رمز عبور معتبر نیستند');

            return view('auth.login')
                ->with('phone_number', $user->phone_number)
                ->with('avatar', $user->avatar())
                ->with('full_name', $user->full_name);
        }
    }

    public function passwordRedirect($request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        /** there is no account with requested phone number */
        if(empty($user)){
            Flash::error('اطلاعات معتبر نیستند');

            return redirect(route('auth.account'));
        }

        Flash::error('اطلاعات معتبر نیستند');

        return view('auth.login')
            ->with('email', $user->email)
            ->with('avatar', $user->avatar())
            ->with('full_name', $user->full_name);
    }
}
