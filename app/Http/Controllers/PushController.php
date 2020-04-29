<?php

namespace App\Http\Controllers;

use App\Notifications\PrivateNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PushController extends Controller
{

    public function __construct(){
//        $this->middleware('auth');
    }

    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = auth('api')->user();
        $user = User::firstOrCreate([
            'endpoint' => $endpoint
        ]);
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true],200);
    }

    /**
     * Send Push Notifications to all users.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function push($message = false){
        if ($message == false){
            $message = "Default Message.";
        }
        Notification::send(User::all(), new PrivateNotification($message) );
        return redirect()->back();
    }



    /** location listener method for GPS device
     *
     *
     * public function location_listener(Request $request){
        $request->validate([
            'key' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($request->get('key') != 'Wl2H1bsuu5'){
            return response()->json(['code'=>'400', 'message' => 'Not permitted.'], 400);
        }
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        Notification::send(Guest::all(), new LocationListener($latitude, $longitude));
        return response()->json(['code'=>'200', 'message' => 'Success']);
    } */

}
