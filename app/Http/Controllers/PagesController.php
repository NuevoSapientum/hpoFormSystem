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

    public function get_positions(){
        return DB::select("select * FROM position");
    }

    public function position(){
        // $positions = DB::select('select position.position_name FROM position LEFT JOIN users ON :user_id = position.position_id', ['user_id' => Auth::user()->position_id]);
        $positions = DB::select('select position_name FROM position where :user_id = position_id', ['user_id' => Auth::user()->position_id]);
        return $positions; 
    }

    // /**
    // *Display the Create Account page
    // *
    // * 
    // * 
    // */
    // public function createAccount(){
    //     $positions = DB::select("select * FROM position");
    //     // return view('auth.register')->with('title', 'Create Account')->with('positions_all', $positions);
    // }

    /**
    *Display the Home Page
    *
    */
    public function dashboard(Request $request){
        $positions = $this->position();
        return view('dashboard')->with('title', 'Home')->with('positions', $positions);
    }

    /**
    *Display the History Page
    *
    */
    public function history(){
        $positions = $this->position();
        return view('history')->with('title', 'History')->with('positions', $positions);
    }

    /**
    *Display the Exit Pass Form Page
    *
    */
    public function exitForm(){
        $positions = $this->position();
        // $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
        // $Supervisors = 
        // $PMs =
        // $CompanyRep =
        return view('exitForm')->with('title', 'Exit Pass')->with('positions', $positions)->with('HRs', $HRs);
    }

    public function postexitForm(Request $request){
        $validator = $this->exitValidator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->exitAdd($request->all());
        return redirect('/exitForm');
    }
    
    protected function exitValidator(array $data)
    {
        // $data['']
        return Validator::make($data, [
            'dateCreated' => 'required',
            'department' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'purpose' => 'required|max:255',
            'supervisor' => 'required',
            'projectManager' => 'required',
            'HR' => 'required',
            'companyRep' => 'required',
        ]);
    }

    protected function exitAdd(array $data)
    {
        $id = Auth::user()->id;
        $dateUpdate = date("Y-m-d H:i:s");
        $db = DB::insert('INSERT INTO `tbl_epform`(`user_id`, `dateCreated`, `dateFrom`, `dateTo`, `textPurpose`, `dateUpdated`) values(?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['dateFrom'], $data['dateTo'], $data['purpose'], $dateUpdate]);
    }

    /**
    *Display the Request for Leave of Absence Form Page
    *
    */
    public function requestForLeave(){
        $positions = $this->position();
        return view('requestForLeave')->with('title', 'Request for Leave of Absence')->with('positions', $positions);
    }

    public function postrequestForLeave(Request $request){
        $validator = $this->requestValidator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->requestAdd($request->all());
        return redirect('requestForLeave');
    }


    protected function requestValidator(array $data)
    {
        // $data['']
        return Validator::make($data, [
            'dateCreated' => 'required',
            'typeofLeave' => 'required',
            'reason' => 'required',
            'recommendApproval' => 'required',
            'approvedBy' => 'required',
        ]);
    }

    protected function requestAdd(array $data)
    {
        $id = Auth::user()->id;
        $db = DB::insert('INSERT INTO `tbl_leave`(`username`, `date_Created`, `reason`, `leave_type`) values(?, ?, ?, ?)', [$id, $data['dateCreated'], $data['reason'], $data['typeofLeave']]);
    }


    /**
    *Display the Change Schedule Form Page
    *
    */
    public function changeSchedule(){
        $positions = $this->position();
        return view('changeSchedule')->with('title', 'Change Schedule')->with('positions', $positions);
    }

    public function postchangeSchedule(Request $request){
        dd($request->all());
    }

    /**
    *Display the Overtime Authorization Slip Form Page
    *
    */
    public function overtimeAuthSlip(){
        $positions = $this->position();
        return view('overtimeAuthSlip')->with('title', 'Overtime Authorization Slip')->with('positions', $positions);
    }

    public function postovertimeAuthSlip(Request $request){
        $validator = $this->overtimeAuthSlipValidator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->overtimeAuthSlipAdd($request->all());
        return redirect('overtimeAuthSlip');
    }

    protected function overtimeAuthSlipValidator(array $data)
    {
        // $data['']
        return Validator::make($data, [
            'dateCreated' => 'required',
            'department' => 'required',
            'client' => 'required',
            'reason' => 'required',
        ]);
    }

    protected function overtimeAuthSlipAdd(array $data)
    {
        $id = Auth::user()->id;
        $db = DB::insert('INSERT INTO `tbl_oas`(`username`, `date_Created`, `reason`, `client_id`) values(?, ?, ?, ?)', [$id, $data['dateCreated'], $data['reason'], $data['client']]);
    }

    public function getProfile(){
        $positions = $this->position();
        $positions_all = $this->get_positions();
        return view('auth.editProfile')->with('title', 'Edit Profile')->with('positions', $positions)->with('positions_all', $positions_all);
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
        Auth::user()->emp_name = $data['name'];
        Auth::user()->position_id = $data['position'];
        Auth::user()->email = $data['email'];
        return Auth::user()->save();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'position' => 'required',
            'email' => 'required|email|max:255',
        ]);
    }

    /*Managing Accounts*/

    public function accounts(){
        // $users = DB::table('users')->select('username', 'emp_name', 'emp_position', 'email')->groupBy('username')->get();
        $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $positions = $this->position();
        return view('auth.accounts')->with('title', 'Manage Accounts')->with('users', $users)->with('positions', $positions);
    }

    /*Update the basic informations*/

    public function show($id){
        $user = User::find($id);
        $positions = $this->position();
        $positions_all = $this->get_positions();
        return view('auth.editAccount')->with('title', 'Edit Profile')->with('user', $user)->with('positions', $positions)->with('positions_all', $positions_all);
    }

    public function postShow($id, Request $request){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = User::find($id);

        $this->updateAccount($user, $request->all());
        
        return redirect('accounts');
    }

    protected function updateAccount($user, array $data){
        $user->username = $data['username'];
        $user->emp_name = $data['name'];
        $user->emp_position = $data['position'];
        $user->email = $data['email'];
        $user->save();
    }

    /*Reset Password*/

    public function resetPassword($id){
        $user = User::find($id);
        $positions = $this->position();
        return view('auth.resetPassword')->with('title', 'Edit Profile')->with('user', $user)->with('positions', $positions);
    }

    public function postResetPassword($id, Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = User::find($id);

        $user->password = bcrypt($request->input('password'));
        $user->save();
        return redirect('accounts');
    }

}
