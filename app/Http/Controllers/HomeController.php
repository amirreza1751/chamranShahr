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
        if(Auth::user()->hasRole('manager')){

            $departments = collect();
            $externalServicesCount = 0;
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                if (isset($manage_history->managed)) {
                    $department = Department::where('id', $manage_history->managed->id)->first();
                    if (isset($department)){
                        $departments->push($department);
                        if (!empty($department->externalServices)){
                            $externalServicesCount =+ sizeof($department->externalServices);
                        }
                    }
                }
            }
            return view('homes.manager_home')
                ->with('departments', $departments)
                ->with('externalServicesCount', $externalServicesCount);
        }
        else
            return view('homes.basic_home');

    }
}
