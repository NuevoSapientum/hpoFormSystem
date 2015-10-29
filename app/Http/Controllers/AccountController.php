<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ExitPass;
use App\Leaves;
use App\Change;
use App\Overtime;
use App\Positions;
use Auth;
use App\User;
use DB;
use App\PagesController;
use Validator;
use Illuminate\Database\Eloquent;
use App\Departments;
use App\Shifts;

class AccountController extends Controller
{

    public function inboxNotif(){
        $exitPass = ExitPass::where('user_id', Auth::user()->id)
                    ->where('status', 0)->get();
        $leaveForm = Leaves::where('user_id', Auth::user()->id)
                     ->where('status', 0)->get();
        $changeSchedule = Change::where('user_id', Auth::user()->id)
                          ->where('status', 0)->get();
        $oas = Overtime::where('user_id', Auth::user()->id)
               ->where('status', 0)->get();
        // dd($oas);
        return $inboxNotif = count($exitPass) + count($leaveForm) + count($changeSchedule) + count($oas);
    }


    public function approvalNotif(){
        $id = Auth::user()->id;
        $exitPass = ExitPass::where('status', 0)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id)
                                ->orWhere('permission_id3', $id)
                                ->orWhere('permission_id4', $id);
                            })
                            ->get();
       $leaveForm = Leaves::where('status', 0)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id);
                            })
                            ->get();
       $changeSchedule = Change::where('status', 0)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id)
                                ->orWhere('permission_id3', $id)
                                ->orWhere('permission_id4', $id);
                            })
                            ->get();
        $overtime = Overtime::where('status', 0)
                            ->where('permission_id1', $id)
                            ->get();

        return count($exitPass) + count($leaveForm) + count($changeSchedule) + count($overtime);
    }

    protected function position(){
        $positions = Positions::where('id', Auth::user()->position_id)->get();
        return $positions; 
    }

    protected function getImage(){
        $con=mysqli_connect("localhost","root","password","hpodb");
        $qry = "select * from profile_image where id = '".Auth::user()->img_id."'";
        
        return $result = mysqli_query($con, $qry);
    }

    public function forms(){
        $exitPass = ExitPass::where('status', '!=', 3)->get();
        $leaveForm = Leaves::where('status', '!=', 3)->get();
        $changeSchedule = Change::where('status', '!=', 3)->get();
        $oas = Overtime::where('status', '!=', 3)->get();
        return count($exitPass) + count($leaveForm) + count($changeSchedule) + count($oas);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $users = DB::table("positions")
                ->join('users', 'users.position_id', '=', 'positions.id')
                ->get();
        $positions = $this->position();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $departments = Departments::where('status', '!=', 1)->get();
        $positions = Positions::where('status', '!=', 1)->get();
        $shifts = Shifts::where('status', '!=', 1)->get();
        $count = $this->forms();
        $data = array(
                    'title' => 'Manage Accounts',
                    'users' => $users,
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'departments' => $departments,
                    'positions' => $positions,
                    'shifts' => $shifts,
                    'count' => $count
            );
        // dd($departments);
        return view('auth.accounts')->with($data);
    }


    /*
    *Change Password of an account
    */
    public function resetPassword($id)
    {
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $user = User::find($id);
        $positions = $this->position();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $count = $this->forms();
        $data = array(
                    'title' => 'Reset Password',
                    'user' => $user,
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'count' => $count
            );
        return view('auth.resetPassword')->with($data);
    }


    public function postResetPassword($id, Request $request)
    {
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
        $result = $user->save();
        if($result){
            $status = "Success!";
        }else{
            $status = "Failed!";
        }
        return redirect('accounts')->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $user = User::find($id);
        $positions = $this->position();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $positions_all = Positions::all();
        $count = $this->forms();
        $data = array(
                    'title' => 'Edit User Profile',
                    'user' => $user,
                    'positions' => $positions,
                    'positions_all' => $positions_all,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'count' => $count
            );
        // dd($user);
        return view('auth.editAccount')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $user->username = $request->username;
        $user->emp_name = $request->name;
        if($request->gender == "Male"){
            $user->ML_entitlement = 0;
            $user->PL_entitlement = $request->PL_entitlement;
            $user->emp_gender = $request->gender;
        }elseif($request->gender == "Female"){
            $user->ML_entitlement = $request->ML_entitlement;
            $user->PL_entitlement = 0;
            $user->emp_gender = $request->gender;
        }
        $user->position_id = $request->position;
        $user->email = $request->email;
        $user->permissioners = $request->permissioners;
        $user->VL_entitlement = $request->VL_entitlement;
        $user->SL_entitlement = $request->SL_entitlement;
        $user->save();

        if($user){
            $status = "Success!";
        }else{
            $status = "Failed!";
        }
        // dd($request->all());

        return redirect('accounts')->with('status', $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeEntitlement(Request $request){
        $status = null;

        if($request->input('VL_entitlement') != 0){
            $result = User::where('id', '!=', 0)
                          ->update(array(
                          'VL_entitlement' => $request->input('VL_entitlement')
                    ));

            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
        }

        if($request->input('SL_entitlement') != 0){
            $result = User::where('id', '!=', 0)
                          ->update(array(
                          'SL_entitlement' => $request->input('SL_entitlement')
                    ));

            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
        }

        if($request->input('ML_entitlement') != 0){
            $result = User::where('id', '!=', 0)
                          ->where('emp_gender', 'Female')
                          ->update(array(
                          'ML_entitlement' => $request->input('ML_entitlement')
                    ));

            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
        }

        if($request->input('PL_entitlement') != 0){

            $result = User::where('id', '!=', 0)
                         ->where('emp_gender', 'Male')
                         ->update(array(
                          'PL_entitlement' => $request->input('PL_entitlement'),
                        ));
                
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
        }

        return redirect('/accounts')->with('status',$status);
    }

    public function addDepartment(Request $request){
        if($request->input('department_name') == ''){
            return redirect('/accounts');
        }else{
            $departments = Departments::all();
            foreach ($departments as $department) {
                if(strcasecmp($department->department_name, $request->input('department_name')) == 0){
                    $status = "Department is already exist!";
                    return redirect('/accounts')->with('status', $status);
                }
            }
            $result = Departments::create([
                        'department_name' => $request->input('department_name')
            ]);

            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }

            return redirect('/accounts')->with('status', $status);

        }
        // dd($request->all());
    }

    public function addPosition(Request $request){
        if($request->input('position_name') == ''){
            return redirect('/accounts');
        }else{
            $positions = Positions::all();
            foreach ($positions as $position) {
                if(strcasecmp($position->position_name, $request->input('position_name')) == 0){
                    $status = "Position is already exist!";
                    return redirect('/accounts')->with('status', $status);
                }
            }
            $result = Positions::create([
                        'position_name' => $request->input('position_name'),
                        'department_id' => $request->input('department')
            ]);

            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }

            return redirect('/accounts')->with('status', $status);

        }
        // dd($request->all());
        // echo $request->input('department');
    }

    public function addSchedule(Request $request){
        $shifts = Shifts::all();

        foreach ($shifts as $shift) {
            if(strtotime($shift->shift_from) == strtotime($request->input('shift_from'))){
                if(strtotime($shift->shift_to) == strtotime($request->input('shift_to'))){
                    $status = "Error: Schedule is already been in the database.";
                    break;
                }else{
                    $status = "Success!";
                }
            }else{
                $status = "Success!";
            }
        }

        if($status == "Success!"){
            $result = Shifts::create([
                                    'shift_from' => $request->input('shift_from'),
                                    'shift_to' => $request->input('shift_to')
                            ]);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
        }

        return redirect('/accounts')->with('status', $status);
    }

    public function deleteDepartment(Request $request){
        $result = Departments::where('id', $request->input('department'))
                        ->update(array(
                        'status' => 1,
        ));

        if($result){
            $status = "Success!";
        }else{
            $status = "Failed!";
        }

        return redirect('/accounts')->with('status', $status);
    }

    public function deletePosition(Request $request){
        $result = Positions::where('id', $request->input('position'))
                        ->update(array(
                        'status' => 1,
        ));

        if($result){
            $status = "Success!";
        }else{
            $status = "Failed!";
        }

        return redirect('/accounts')->with('status', $status);
    }

    public function deleteSchedule(Request $request){
        $result = Shifts::where('id', $request->input('schedule'))
                        ->update(array(
                        'status' => 1,
        ));

        if($result){
            $status = "Success!";
        }else{
            $status = "Failed!";
        }

        return redirect('/accounts')->with('status', $status);
    }

}
