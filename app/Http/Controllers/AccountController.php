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

class AccountController extends Controller
{

    public function inboxNotif(){
        $exitPass = ExitPass::where('user_id', Auth::user()->id)
                    ->where('status', '!=', '3')->get();
        // $exitPass = DB::select("SELECT * FROM tbl_epform WHERE id = :user_id AND status != 2", ['user_id' => Auth::user()->id]);
        $leaveForm = Leaves::where('user_id', Auth::user()->id)
                     ->where('status', '!=', '3')->get();
        // $leaveForm = DB::select("SELECT * FROM tbl_leave WHERE id = :user_id AND status != 2", ['user_id' => Auth::user()->id]);
        $changeSchedule = Change::where('user_id', Auth::user()->id)
                          ->where('status', '!=', '3')->get();
        // $changeSchedule = DB::select("SELECT * FROM tbl_chgschd WHERE id = :user_id AND status != 2", ['user_id' => Auth::user()->id]);
        $oas = Overtime::where('user_id', Auth::user()->id)
               ->where('status', '!=', '3')->get();
        // $oas = DB::select("SELECT * FROM tbl_oas WHERE id = :user_id AND status != 1", ['user_id' => Auth::user()->id]);
         //   
        // dd($exitPass);
        return $inboxNotif = count($exitPass) + count($leaveForm) + count($changeSchedule) + count($oas);
    }


    public function approvalNotif(){
        $id = Auth::user()->id;
        $exitPass = ExitPass::where('status', '!=', 3)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id)
                                ->orWhere('permission_id3', $id)
                                ->orWhere('permission_id4', $id);
                            })
                            ->get();
       $leaveForm = Leaves::where('status', '!=', 3)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id);
                            })
                            ->get();
       $changeSchedule = Change::where('status', '!=', 3)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id)
                                ->orWhere('permission_id3', $id)
                                ->orWhere('permission_id4', $id);
                            })
                            ->get();
        $overtime = Overtime::where('status', '!=', 3)
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
        $departments = Departments::all();
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
        $rules =  array([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|',
        ]);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = User::find($id);

        $user->username = $request->username;
        $user->emp_name = $request->name;
        $user->position_id = $request->position;
        $user->email = $request->email;
        $user->permissioners = $request->permissioners;
        $user->VL_entitlement = $request->VL_entitlement;
        $user->SL_entitlement = $request->SL_entitlement;
        $user->ML_entitlement = $request->ML_entitlement;
        $user->PL_entitlement = $request->PL_entitlement;
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
                          ->update(array(
                          'PL_entitlement' => $request->input('PL_entitlement')
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
                        'departments_id' => $request->input('department')
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
}
