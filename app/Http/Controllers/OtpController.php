<?php

namespace App\Http\Controllers\API;

use App\PhonenumberToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Output\ConsoleOutput;

class OtpController extends Controller
{
    public function send_otp(Request $request)
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
                'message'=> 'The given data was invalid.',
                'errors'=> [
                    'phone_number' => [
                        'فرمت شماره تلفن همراه صحیح نیست'
                    ]
                ],
            ], 422);
        }

        $today_phonenumber_tokens = PhonenumberToken::where('phone_number', $input['phone_number'])->where('used', '0')->where('created_at', '>', Carbon::now()->subDay())->get();

        if($today_phonenumber_tokens->count() >= 15){
            return response()->json([
                'success' => false,
                'message'=> 'تعداد مجاز درخواست کد احراز شماره تلفن همراه به پایان رسیده است.',
            ], 429);
        }

        $phonenumber_tokens_last = PhonenumberToken::where('phone_number', $input['phone_number'])->get()->last();

        if (isset($phonenumber_tokens_last) && !$phonenumber_tokens_last->used && $phonenumber_tokens_last->created_at > Carbon::now()->subMinutes(2)){
            /**
             * after two minutes,
             * new token will be create for specific phone number,
             * otherwise this error will appear
             */
            return response()->json([
                'success' => false,
                'message'=> 'متاسفانه خطایی رخ داده است، لطفا مجددا تلاش کنید',
            ], 425);
        }

        $token = mt_rand(10000,99999);
        $client1 =  new Client();
        $r = $client1->request('POST',
            'https://api.kavenegar.com/v1/31453435764C6968545A545665696C63596A45654552535645626966336D374236716139743550557839453D/verify/lookup.json?receptor='.$request->phone_number.'&token='.$token.'&template=chamran-shahr',
            ['verify' => false]);
        $result = \GuzzleHttp\json_decode($r->getBody());

        if( $result->return->status == 200){
            foreach (PhonenumberToken::where('phone_number', $request->phone_number)->get() as $phonenumber_token){
                $phonenumber_token->deleted_at = Carbon::now();
                $phonenumber_token->save();
            }
            PhonenumberToken::create([
                'phone_number' => $request->phone_number,
                'token' => $token,
                'used' => '0'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'کد احراز شماره تلفن همراه با موفقیت ارسال شد']
                , 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'متاسفانه خطایی در ارسال پیام رخ داده است، لطفا مجددا تلاش کنید'], $result->return->status);
        }
    }
}
