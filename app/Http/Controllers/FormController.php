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
use App\Departments;
use DB;
use App\PagesController;
use Validator;

class FormController extends Controller
{
    public function inboxNotif(){
        $exitPass = ExitPass::where('user_id', Auth::user()->id)
                    ->where('status', '!=', '3')->get();
        $leaveForm = Leaves::where('user_id', Auth::user()->id)
                     ->where('status', '!=', '3')->get();
        $changeSchedule = Change::where('user_id', Auth::user()->id)
                          ->where('status', '!=', '3')->get();
        $oas = Overtime::where('user_id', Auth::user()->id)
               ->where('status', '!=', '3')->get();
        return $inboxNotif = count($exitPass) + count($leaveForm) + count($changeSchedule) + count($oas);
    }


    public function approvalNotif(){
        $id = Auth::user()->id;
        // $exitPass = DB::select("SELECT * FROM tbl_epform JOIN users ON tbl_epform.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2 OR permission_id3 = :id3
                            // OR permission_id4 = :id4", ['id1' => $id, 'id2' => $id, 'id3' => $id, 'id4' => $id]);
        $exitPass = ExitPass::where('status', '!=', 3)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id)
                                ->orWhere('permission_id3', $id)
                                ->orWhere('permission_id4', $id);
                            })
                            ->get();
        // $leaveForm = DB::select("SELECT * FROM tbl_leave JOIN users ON tbl_leave.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2", 
                                // ['id1' => $id, 'id2' => $id]);
        $leaveForm = Leaves::where('status', '!=', 3)
                            ->where(function($query){
                                $id = Auth::user()->id;
                                $query->where('permission_id1', $id)
                                ->orWhere('permission_id2', $id);
                            })
                            ->get();
        // $changeSchedule = DB::select("SELECT * FROM tbl_chgschd JOIN users ON tbl_chgschd.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2 OR permission_id3 = :id3
                            // OR permission_id4 = :id4", ['id1' => $id, 'id2' => $id, 'id3' => $id, 'id4' => $id]);
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
                            ->where('permission_id1', $id);
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

    /*Exif Pass Form Functions*/

    public function exitForm(){
        $inboxNotif = $this->inboxNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $department = Positions::find($id)->departments;
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $HRs = DB::table("positions")
                ->join('users', 'users.position_id', '=', 'positions.id')
                ->where('positions.departments_id', 8)
                ->get();
        $Supervisors = User::where('permissioners', 1)->get();
        $PMs = User::where('permissioners', 2)->get();
        $CompanyReps = User::where('permissioners', 3)->get();
        $data = array(
                    'title' => 'Exit Pass',
                    'positions' => $positions,
                    'HRs' => $HRs,
                    'Supervisors' => $Supervisors,
                    'PMs' => $PMs,
                    'CompanyReps' => $CompanyReps,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment
        );
        return view('exitForm')->with($data);
    }

    public function postexitForm(Request $request){
        $rules = array('dateCreated' => 'required',
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

        $id = Auth::user()->id;
        $department = Positions::find(Auth::user()->position_id)->departments;
        $dateUpdate = date("Y-m-d H:i:s");
        $exitPass = new ExitPass(array(
            'user_id' => $id,
            'created_at' => $request->input('dateCreated'),
            'date_from' => $request->input('dateFrom'),
            'date_to' => $request->input('dateTo'),
            'purpose' => $request->input('purpose'),
            'updated_at' => $dateUpdate,
            'department_id' => $department->id,
            'permission_id1' => $request->input('supervisor'),
            'permission_id2' => $request->input('projectManager'),
            'permission_id3' => $request->input('HR'),
            'permission_id4' => $request->input('companyRep')
        ));


        // dd($request->all());

        $newDate = "2011-01-07";
        $newDate = $request->input('dateFrom');

        // echo $newDate;
        $newFormat = date('Y-m-d H:i:s', strtotime($newDate));
        echo $newFormat;

        // echo $request->input('dateFrom');
        // $save = $exitPass->save();

        // if($save){
        //     $status = "Success!";
        // }else{
        //     $status = "Failed!";
        // } 
        // return redirect('/inbox')->with('status', $status);
    }

    /*Request for Leave of Absence Form Functions*/

    public function requestForLeave(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $permissioners = User::where('permissioners', '!=', 0)->get();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $data = array(
                    'title' => 'Request for Leave of Absence',
                    'positions' => $positions,
                    'permissioners' => $permissioners,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment
            );
        
        return view('requestForLeave')->with($data);
    }

    public function postrequestForLeave(Request $request){
        $rules = array('dateCreated' => 'required',
                       'typeofLeave' => 'required',
                       'reasonforAbsence' => 'required',
                       'recommendApproval' => 'required',
                       'approvedBy' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $id = Auth::user()->id;
        $dateUpdate = date("Y-m-d H:i:s");
        if($request->input('days_applied') != 0 && $request->input('days_applied') <= 7){
            $days_taken = Auth::user()->days_taken + $request->input('days_applied');
            if(Auth::user()->days_taken == Auth::user()->entitlement){
                $status = "Failed!";
            }else{
                Auth::user()->days_taken = $days_taken;
                Auth::user()->save();
                $department = Positions::find(Auth::user()->position_id)->departments;
                $requestAdd = new Leaves(array(
                    'user_id' => $id,
                    'leave_type' => $request->input('typeofLeave'),
                    'purpose' => $request->input('reasonforAbsence'),
                    'department_id' => $department->id,
                    'permission_id1' => $request->input('recommendApproval'),
                    'permission_id2' => $request->input('approvedBy'),
                    'days_applied' => $request->input('days_applied'),
                    'created_at' => $request->input('dateCreated'),
                    'updated_at' => $dateUpdate
                ));


                $save = $requestAdd->save();
                if($save){
                    $status = "Success!";
                }else{
                   $status = "Failed!";
                }
            }
            
            return redirect('/inbox')->with('status', $status);
        }        
    }

    /*Change Schedule Form Functions*/

    public function changeSchedule(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $id = Auth::user()->position_id;
        $permissioners = User::where('permissioners', '!=', 0)->get();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $HRs = DB::table("positions")
                ->join('users', 'users.position_id', '=', 'positions.id')
                ->where('positions.departments_id', 8)
                ->get();
        $Supervisors = User::where('permissioners', 1)->get();
        $PMs = User::where('permissioners', 2)->get();
        $CompanyReps = User::where('permissioners', 3)->get();
        $data = array(
                    'title' => 'Change Schedule',
                    'positions' => $positions,
                    'HRs' => $HRs,
                    'Supervisors' => $Supervisors,
                    'PMs' => $PMs,
                    'CompanyReps' => $CompanyReps,
                    'permissioners' => $permissioners,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment
            );
        return view('changeSchedule')->with($data);
    }

    public function postchangeSchedule(Request $request){
        $rules = array('dateCreated' => 'required',
                       'dateFromEffectivity' => 'required',
                       'dateToEffectivity' => 'required',
                       'dateFromShift' => 'required',
                       'dateToShift' => 'required',
                       'reasonforChangeSchedule' => 'required',
                       'supervisor' => 'required',
                       'projectManager' => 'required',
                       'HR' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $dateUpdate = date("Y-m-d H:i:s");
        $department = Positions::find(Auth::user()->position_id)->departments;
        $changes = new Change(array(
                'user_id' => Auth::user()->id,
                'department_id' => $department->id,
                'permission_id1' => $request->input('supervisor'),
                'permission_id2' => $request->input('projectManager'),
                'permission_id3' => $request->input('permissioner'),
                'permission_id4' => $request->input('HR'),
                'purpose' => $request->input('reasonforChangeSchedule'),
                'created_at' => $request->input('dateCreated'),
                'updated_at' => $dateUpdate,
                'date_from' => $request->input('dateFromEffectivity'),
                'date_to' => $request->input('dateToEffectivity'),
                'shift_from' => $request->input('dateFromShift'),
                'shift_to' => $request->input('dateToShift')

            ));

        $result = $changes->save();
        if($result){
            $status = "Success!";
        }else{
            $status = "Failed!";
        }

        return redirect('inbox')->with('status', $status);
    }


    public function overtimeAuthSlip(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $Supervisors = User::where('permissioners', 1)->get();
        $data = array(
                    'title' => 'Overtime Authorization Slip',
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'Supervisors' => $Supervisors
            );
        return view('overtimeAuthSlip')->with($data);
    }

    public function postovertimeAuthSlip(Request $request){
        $rules = array('dateCreated' => 'required',
                       'client' => 'required',
                       'purpose' => 'required',
                       'supervisor' => 'required');

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $dateUpdate = date("Y-m-d H:i:s");
        $department = Positions::find(Auth::user()->position_id)->departments;

        $overtime = new Overtime(array(
                        'user_id' => Auth::user()->id,
                        'department_id' => $department->id,
                        'purpose' => $request->input('purpose'),
                        'client_id' => $request->input('client'),
                        'created_at' => $request->input('dateCreated'),
                        'updated_at' => $dateUpdate,
                        'permission_id1' => $request->input('supervisor')
        ));

        $result = $overtime->save();

        if($result){
            $status = "Success!";
        }else{
            $status = "Failed";
        }

        return redirect('inbox')->with('status', $status);
    }

}
