<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    /**
    *Display the login page
    *
    * 
    * 
    */
    public function login(){
        return view('auth.login');
    }
    
    /**
    *Display the Home Page
    *
    */
    public function dashboard(){
        return view('dashboard')->with('title', 'Home');
    }

    /**
    *Display the History Page
    *
    */
    public function history(){
        return view('history')->with('title', 'History');
    }

    /**
    *Display the Exit Pass Form Page
    *
    */
    public function exitForm(){
        return view('exitForm')->with('title', 'Exit Pass');
    }

    /**
    *Display the Request for Leave of Absence Form Page
    *
    */
    public function requestForLeave(){
        return view('requestForLeave')->with('title', 'Request for Leave of Absence');
    }

    /**
    *Display the Change Schedule Form Page
    *
    */
    public function changeSchedule(){
        return view('changeSchedule')->with('title', 'Change Schedule');
    }

    /**
    *Display the Overtime Authorization Slip Form Page
    *
    */
    public function overtimeAuthSlip(){
        return view('overtimeAuthSlip')->with('title', 'Overtime Authorization Slip');
    }


}
