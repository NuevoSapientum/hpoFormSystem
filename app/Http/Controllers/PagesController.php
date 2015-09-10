<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\User;
use Auth;

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
    *Display the Create Account page
    *
    * 
    * 
    */
    public function createAccount(){
        return view('auth.register')->with('title', 'Create Account');
    }

    /**
    *Display the Home Page
    *
    */
    public function dashboard(Request $request){
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

    public function getProfile(){
        return view('auth.editProfile')->with('title', 'Edit Profile');
    }

    public function postProfile(Request $request){
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->edit($request->all());

        return redirect('/');
    }

    protected function edit(array $data)
    {
        Auth::user()->username = $data['username'];
        Auth::user()->emp_name = $data['name'];
        Auth::user()->emp_position = $data['position'];
        Auth::user()->email = $data['email'];
        return Auth::user()->save();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'position' => 'required',
            'email' => 'required|email|max:255',
        ]);
    }

}
