<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('developer')){
            return $this->developer();
        }
        elseif(Auth::user()->hasRole('client_developer')){
            return $this->client_developer();
        }
        elseif(Auth::user()->hasRole('manager')){
            return $this->manager();
        }
        else
            return view('homes.basic_home');

    }

    public function developer()
    {
        return view('homes.developer_home');
    }

    public function manager()
    {
        $departments = collect();
        $externalServicesCount = 0;
        $newsCount = 0;
        $noticesCount = 0;
        $manage_histories = Auth::user()->under_managment();
        foreach ($manage_histories as $manage_history) {
            if (isset($manage_history->managed)) {
                $department = Department::where('id', $manage_history->managed->id)->first();
                if (isset($department)){
                    $departments->push($department);
                    if (!empty($department->externalServices)){
                        $externalServicesCount =+ sizeof($department->externalServices);
                        $newsCount =+ sizeof($department->news);
                        $noticesCount =+ sizeof($department->notices);
                    }
                }
            }
        }
        return view('homes.manager_home')
            ->with('departments', $departments)
            ->with('externalServicesCount', $externalServicesCount)
            ->with('newsCount', $newsCount)
            ->with('noticesCount', $noticesCount);
    }

    public function client_developer()
    {
        return view('homes.client_developer_home');
    }

    public function empty(Request $request)
    {
        dump($request);
    }
}
