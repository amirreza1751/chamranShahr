<?php

namespace App\Http\Controllers\API;

use App\PhonenumberToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{
    public function send_otp(Request $request)
    {

        $request->validate([
            'phone_number' => 'required|regex:/^((0)[0-9\s\-\+\(\)]*)$/|min:10',
//            'phone_number' => 'required',
            // sample phone number 09126774496
        ]);
        $token = mt_rand(10000,99999);
        $client1 =  new Client();
        $r = $client1->request('POST',
            'https://api.kavenegar.com/v1/31453435764C6968545A545665696C63596A45654552535645626966336D374236716139743550557839453D/verify/lookup.json?receptor='.$request->phone_number.'&token='.$token.'&template=chamran-shahr',
            ['verify' => false]);
        $result = \GuzzleHttp\json_decode($r->getBody());
        PhonenumberToken::create([
            'phone_number' => $request->phone_number,
            'token' => $token,
//            'date' => $result->entries[0]->date
            'used' => '0'
        ]);
        if( $result->return->status == 200){
            return response()->json(['status' => 'otp sent.'], 200);
        } else {
            return response()->json(['status' => 'failed to send otp.'], $result->return->status);
        }
    }
}
