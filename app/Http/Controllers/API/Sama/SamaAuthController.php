<?php

namespace App\Http\Controllers\API\Sama;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SamaAuthController extends Controller
{
    public function sama_login()
    {
        $cookie = config_path('cookie/cookie.txt');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "mreg.scu.ac.ir/samawebservices/services/authenticationservice.svc/web/login?username=ChamranUser&password=chamran@123",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(

            ),
            CURLOPT_COOKIEJAR => $cookie,
        ));

         $response = curl_exec($curl);
//        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        if ($response == 'true')
            return true;
        else return false;
    }
}
