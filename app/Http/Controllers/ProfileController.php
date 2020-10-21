<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
    {
        if(Auth::user()->hasRole('manager')){
            return view('profiles.manager_profile');
        }
    }
}
