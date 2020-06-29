<?php

namespace App\Http\Controllers\API\Sama;

use App\General\ConsoleColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SamaAuthController extends Controller
{
    public function sama_login()
    {
        $cc = new ConsoleColor();
//        $cc->print_error('sama_login is executing...');
        try {
            if (!is_dir(base_path() . "/" . 'config/cookie')){
                File::makeDirectory(base_path() . "/" . 'config/cookie');
//                $cc->print_warning('cookie directory was created');
            }
            if(!file_exists( base_path() . "/" . 'config/cookie/cookie.txt')){
                File::put(base_path() . "/" . 'config/cookie/cookie.txt', 'w');
//                $cc->print_warning('cookie file was created');
            }
            $cookie = config_path('cookie/cookie.txt');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "mreg.scu.ac.ir/samawebservices/services/authenticationservice.svc/web/login?username=ChamranUser&password=ChamranUser@2064",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(),
                CURLOPT_COOKIEJAR => $cookie,
            ));

            $response = curl_exec($curl);
            //        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
            if ($response == 'true')
                return true;
            else return false;
        } catch (\Exception $e){
            $cc->print_error($e);
        }
    }
}
