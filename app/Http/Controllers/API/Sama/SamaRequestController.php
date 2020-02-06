<?php

namespace App\Http\Controllers\API\Sama;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SamaRequestController extends Controller
{
    public static function sama_request( $service, $method, $parameters)
    {
        $cookie = config_path('cookie/cookie.txt');

        $curl = curl_init();
        $data = http_build_query($parameters);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://mreg.scu.ac.ir/samawebservices/services/".$service.".svc/web/".$method."?".$data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_COOKIEFILE => $cookie
        ));

        $response = curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpcode == 200){
            return json_decode($response);
        } elseif ($httpcode == 400){
            $login_result = app('App\Http\Controllers\API\Sama\SamaAuthController')->sama_login();
            if ($login_result) /**  successful login  **/
                return SamaRequestController::sama_request($service, $method, $parameters);
            else return false; /**  unsuccessful login  **/
        } else return false; /**  404 error  **/
    }
}
