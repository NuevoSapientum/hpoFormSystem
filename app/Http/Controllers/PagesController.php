<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\User;
use Auth;
use Input;

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

    protected function get_positions(){
        return DB::select("select * FROM position");
    }

    protected function position(){
        // $positions = DB::select('select position.position_name FROM position LEFT JOIN users ON :user_id = position.position_id', ['user_id' => Auth::user()->position_id]);
        $positions = DB::select('select position_name FROM position where :user_id = position_id', ['user_id' => Auth::user()->position_id]);
        return $positions; 
    }

    protected function getImage(){
        $con=mysqli_connect("localhost","root","password","hpodb");
        $qry = "select * from profile_image where id = '".Auth::user()->id."'";
        return $result = mysqli_query($con, $qry);
    }

    /**
    *Display the Home Page
    *
    */
    public function dashboard(Request $request){
        $positions = $this->position();
        $profileImage = $this->getImage();

        return view('dashboard')->with('title', 'Home')->with('positions', $positions)->with('profileImage', $profileImage);
    }

    /**
    *Display the History Page
    *
    */
    public function history(){
        $profileImage = $this->getImage();
        $positions = $this->position();
        return view('history')->with('title', 'History')->with('positions', $positions)->with('profileImage', $profileImage);
    }

    public function inbox(){
        $profileImage = $this->getImage();
        $exitPass = DB::select("SELECT * FROM tbl_epform WHERE id = :user_id", ['user_id' => Auth::user()->id]);
        $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $positions = $this->position();
        return view('user.inbox')->with('title', 'Inbox')->with('profileImage', $profileImage)->with('positions', $positions)->with('exitPass', $exitPass)->with('users', $users);
    }

    /**
    *Display the Exit Pass Form Page
    *
    */
    public function exitForm(){
        $profileImage = $this->getImage();
        $positions = $this->position();
        $department = DB::select("SELECT department.* FROM `department` JOIN position ON position.position_id = :user_posid AND department.department_id = position.department_id", ['user_posid' => Auth::user()->position_id]);
        // $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
        $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
        $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
        $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
        return view('exitForm')->with('title', 'Exit Pass')->with('positions', $positions)->with('HRs', $HRs)->with('department_user', $department)->with('Supervisors', $Supervisors)->with('PMs', $PMs)->with('CompanyReps', $CompanyReps)->with('profileImage', $profileImage);
    }

    public function postexitForm(Request $request){
        $rules = array('dateCreated' => 'required',
                       'department' => 'required',
                       'dateFrom' => 'required',
                       'dateTo' => 'required',
                       'purpose' => 'required|max:255',
                       'supervisor' => 'required',
                       'projectManager' => 'required',
                       'HR' => 'required',
                       'companyRep' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->exitAdd($request->all());
        return redirect('/exitForm');
    }

    protected function exitAdd(array $data)
    {
        $id = Auth::user()->id;
        $dateUpdate = date("Y-m-d H:i:s");
        $db = DB::insert('INSERT INTO `tbl_epform`(`user_id`, `dateCreated`, `dateFrom`, `dateTo`, `textPurpose`, `dateUpdated`, `department_id`, `permission_id1`, `permission_id2`, `permission_id3`, `permission_id4`) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['dateFrom'], $data['dateTo'], $data['purpose'], $dateUpdate, $data['department'], $data['supervisor'], $data['projectManager'], $data['HR'], $data['companyRep']]);
    }
    /**
    *Display the Request for Leave of Absence Form Page
    *
    */
    public function requestForLeave(){
        $profileImage = $this->getImage();
        $positions = $this->position();
        $permissioners = DB::select("select * FROM users WHERE permissioners");
        return view('requestForLeave')->with('title', 'Request for Leave of Absence')->with('positions', $positions)->with('permissioners', $permissioners)->with('profileImage', $profileImage);
    }

    public function postrequestForLeave(Request $request){
        $rules = array('dateCreated' => 'required',
                       'typeofLeave' => 'required',
                       'reason' => 'required',
                       'recommendApproval' => 'required',
                       'approvedBy' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->requestAdd($request->all());
        return redirect('requestForLeave');
    }

    protected function requestAdd(array $data)
    {
        $id = Auth::user()->id;
        
        if($data['days_applied'] != 0){
            $days_taken = Auth::user()->days_taken + $data['days_applied'];
            Auth::user()->days_taken = $days_taken;
            Auth::user()->save();
            $db = DB::insert('INSERT INTO `tbl_leave`(`user_id`, `date_Created`, `reason`, `leave_type`, `days_applied`, `permission_id1`, `permission_id2`) values(?, ?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['reason'], $data['typeofLeave'], $data['days_applied'], $data['approvedBy'], $data['recommendApproval']]);
        }
    }


    /**
    *Display the Change Schedule Form Page
    *
    */
    public function changeSchedule(){
        $profileImage = $this->getImage();
        $positions = $this->position();
        $department = DB::select("SELECT department.* FROM `department` JOIN position ON position.position_id = :user_posid AND department.department_id = position.department_id", ['user_posid' => Auth::user()->position_id]);
        // $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $permissioners = DB::select("SELECT * FROM users WHERE permissioners");
        $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
        $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
        $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
        $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
        return view('changeSchedule')->with('title', 'Change Schedule')->with('positions', $positions)->with('HRs', $HRs)->with('department_user', $department)->with('Supervisors', $Supervisors)->with('PMs', $PMs)->with('CompanyReps', $CompanyReps)->with('permissioners', $permissioners)->with('profileImage', $profileImage);
    }

    public function postchangeSchedule(Request $request){
        $rules = array('dateCreated' => 'required',
                       'department' => 'required',
                       'dateFromEffectivity' => 'required',
                       'dateToEffectivity' => 'required',
                       'dateFromShift' => 'required',
                       'dateToShift' => 'required',
                       'reason' => 'required',
                       'supervisor' => 'required',
                       'projectManager' => 'required',
                       'HR' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        // dd($request->all());
        $this->changeScheduleAdd($request->all());
        return redirect('changeSchedule');
    }

    public function changeScheduleAdd(array $data){
        $id = Auth::user()->id;
        $db = DB::insert('INSERT INTO `tbl_chgschd`(`user_id`, `date_Created`, `department`, `date_from`, `date_to`, `shift_from`, `shift_to`, `reason`, `permission_id1`, `permission_id2`, `permission_id3`, `permission_id4`) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['department'], $data['dateFromEffectivity'], $data['dateToEffectivity'], $data['dateFromShift'], $data['dateToShift'], $data['reason'], $data['supervisor'], $data['projectManager'], $data['permissioner'], $data['HR']]);
    }

    /**
    *Display the Overtime Authorization Slip Form Page
    *
    */
    public function overtimeAuthSlip(){
        $profileImage = $this->getImage();
        $positions = $this->position();
        $department = DB::select("SELECT department.* FROM `department` JOIN position ON position.position_id = :user_posid AND department.department_id = position.department_id", ['user_posid' => Auth::user()->position_id]);
        return view('overtimeAuthSlip')->with('title', 'Overtime Authorization Slip')->with('positions', $positions)->with('department_user', $department)->with('profileImage', $profileImage);
    }

    public function postovertimeAuthSlip(Request $request){
        $rules = array('dateCreated' => 'required',
                       'department' => 'required',
                       'client' => 'required',
                       'reason' => 'required');

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->overtimeAuthSlipAdd($request->all());
        return redirect('overtimeAuthSlip');
    }

    protected function overtimeAuthSlipAdd(array $data)
    {
        $id = Auth::user()->id;
        $db = DB::insert('INSERT INTO `tbl_oas`(`username`, `date_Created`, `reason`, `client_id`) values(?, ?, ?, ?)', [$id, $data['dateCreated'], $data['reason'], $data['client']]);
    }

    public function getProfile(){
        $profileImage = $this->getImage();
        $positions = $this->position();
        $positions_all = $this->get_positions();
        return view('auth.editProfile')->with('title', 'Edit Profile')->with('positions', $positions)->with('positions_all', $positions_all)->with('profileImage', $profileImage);
    }

    public function postProfile(Request $request){
        $file = array('image' => Input::file('image'));
        $rules = array('name' => 'required|max:255',
                       'position' => 'required',
                       'email' => 'required|email|max:255');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        if($_FILES['image']['error'] != UPLOAD_ERR_OK){
            die("Upload failed with error code " . $_FILES['image']['error']);
        }

        $info = getimagesize($_FILES['image']['tmp_name']);
        if($info === FALSE){
            // die("<script>alert('Unable to determine image type of upload file');</script>");
        }

        if(($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)){
            // die("Not a gif/jpeg/png");
        }else{
            $image = addslashes($_FILES['image']['tmp_name']);
            $name = addslashes($_FILES['image']['name']);
            $image = file_get_contents($image);
            $image = base64_encode($image);
            $this->updateImage($name, $image);
            $this->edit($request->all());
        }
        return redirect('/');
    }

    public function updateImage($name, $image){
        DB::update("UPDATE `profile_image` SET `name` = :name, `image` = :image WHERE `id` = :user", ['name' => $name, 'image' => $image, 'user' => Auth::user()->id]);
    }

    // public function saveImage($name, $image){
    //     DB::insert("INSERT into `profile_image`(`name`, `image`, `id`) values(?, ?, ?)", [$name, $image, Auth::user()->id]);
    // }

    protected function edit(array $data)
    {
        Auth::user()->emp_name = $data['name'];
        Auth::user()->position_id = $data['position'];
        Auth::user()->email = $data['email'];
        return Auth::user()->save();
    }

    /*Managing Accounts*/

    public function accounts(){
        $profileImage = $this->getImage();
        // $users = DB::table('users')->select('username', 'emp_name', 'emp_position', 'email')->groupBy('username')->get();
        $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $positions = $this->position();
        return view('auth.accounts')->with('title', 'Manage Accounts')->with('users', $users)->with('positions', $positions)->with('profileImage', $profileImage);
    }

    /*Update the basic informations*/

    public function show($id){
        $profileImage = $this->getImage();
        $user = User::find($id);
        $positions = $this->position();
        $positions_all = $this->get_positions();
        return view('auth.editAccount')->with('title', 'Edit Profile')->with('user', $user)->with('positions', $positions)->with('positions_all', $positions_all)->with('profileImage', $profileImage);
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
        $user->position_id = $data['position'];
        $user->email = $data['email'];
        $user->permissioners = $data['permissioners'];
        $user->entitlement = $data['entitlement'];
        $user->days_taken = $data['days_taken'];
        $user->save();
    }

    /*Reset Password*/

    public function resetPassword($id){
        $profileImage = $this->getImage();
        $user = User::find($id);
        $positions = $this->position();
        return view('auth.resetPassword')->with('title', 'Edit Profile')->with('user', $user)->with('positions', $positions)->with('profileImage', $profileImage);
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
