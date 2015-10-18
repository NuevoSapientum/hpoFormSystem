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
use App\Positions;
use App\ExitPass;
use App\Leaves;
use App\Change;
use App\Overtime;
use App\Departments;
use App\Users;
use App\DateTimeOvertime;
use App\DateTimeChange;


class ApprovalController extends Controller
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
        // dd($oas);
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

    public function exitApprovals($id){
        return ExitPass::where('status', '!=', 3)
                    ->where(function($query){
                        $id = Auth::user()->id;
                        $query->where('permission_id1', $id)
                        ->orWhere('permission_id2', $id)
                        ->orWhere('permission_id3', $id)
                        ->orWhere('permission_id4', $id);
                    })
                    ->get();
        // return ExitPass::all();
    }

    public function leaveApprovals($id){
        return Leaves::where('status', '!=', 3)
                    ->where(function($query){
                        $id = Auth::user()->id;
                        $query->where('permission_id1', $id)
                        ->orWhere('permission_id2', $id);
                    })
                    ->get();
    }

    public function changeApprovals($id){
        return Change::where('status', '!=', 3)
                    ->where(function($query){
                        $id = Auth::user()->id;
                        $query->where('permission_id1', $id)
                        ->orWhere('permission_id2', $id)
                        ->orWhere('permission_id3', $id)
                        ->orWhere('permission_id4', $id);
                    })
                    ->get();
    }

    public function overtimeApproval($id){
        return Overtime::where('status', '!=', 3)
                       ->where(function($query){
                        $id = Auth::user()->id;
                        $query->where('permission_id1', $id);
                       })
                       ->get();
    }

    public function index(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $exitApprovals = $this->exitApprovals(Auth::user()->id);
        $leaveApprovals = $this->leaveApprovals(Auth::user()->id);
        $changeApprovals = $this->changeApprovals(Auth::user()->id);
        $overtimeApprovals = $this->overtimeApproval(Auth::user()->id);
        $data = array(
                'title' => "Need Approvals",
                'inboxNotif' => $inboxNotif,
                'positions' => $positions,
                'profileImage' => $profileImage,
                'exitApprovals' => $exitApprovals,
                'leaveApprovals' => $leaveApprovals,
                'changeApprovals' => $changeApprovals,
                'overtimeApprovals' => $overtimeApprovals,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment
            );

        return view('user.approval')->with($data);
    }

    public function viewApproval($type, $id){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $dataFirst = array(
                'inboxNotif' => $inboxNotif,
                'positions' => $positions,
                'profileImage' => $profileImage,
                'approvalNotif' => $approvalNotif
            );
        if($type == 1){
            $contents = ExitPass::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $HRs = DB::table("positions")
                    ->join('users', 'users.position_id', '=', 'positions.id')
                    ->where('positions.departments_id', 8)
                    ->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $PMs = User::where('permissioners', 2)->get();
            $CompanyReps = User::where('permissioners', 3)->get();
            $dataSecond = array(
                        'title' => "Need Approval Edit Exit Pass",
                        'contents' => $contents,
                        'HRs' => $HRs,
                        'Supervisors' => $Supervisors,
                        'PMs' => $PMs,
                        'CompanyReps' => $CompanyReps,
                        'empDepartment' => $empDepartment
                );
            $data = array_merge($dataFirst, $dataSecond);
            // dd($data);
            // echo "1";
            return view('user.approvalExitView')->with($data);
        }elseif($type == 2){
            $contents = Leaves::where('id', $id)->get();
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $dataSecond = array(
                            'title' => "Edit Request for Leave of Absence",
                            'contents' => $contents,
                            'permissioners' => $permissioners,
                            'empDepartment' => $empDepartment
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.approvalRequestView')->with($data);
        }elseif($type == 3){
            $contents = Change::where('id', $id)->get();
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
            $dateTime = DateTimeChange::where('change_id', $id)->get();
            $dataSecond = array(
                            'title' => "Edit Change Schedule",
                            'contents' => $contents,
                            'permissioners' => $permissioners,
                            'HRs' => $HRs,
                            'Supervisors' => $Supervisors,
                            'PMs' => $PMs,
                            'CompanyReps' => $CompanyReps,
                            'empDepartment' => $empDepartment,
                            'dateTime' => $dateTime
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.approvalChangeView')->with($data);
        }elseif($type == 4){
            $contents = Overtime::where('id', $id)->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $dateTime = DateTimeOvertime::where('overtime_id', $id)->get();
            $count = 0;
            $dataSecond = array(
                            'title' => "Edit Change Schedule",
                            'contents' => $contents,
                            'Supervisors' => $Supervisors,
                            'empDepartment' => $empDepartment,
                            'dateTime' => $dateTime,
                            'count' => $count
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.approvalOvertimeView')->with($data);
        }else{
            $status = "Nothing to Show.";
            return redirect('approval')->with('status', $status);
        }
    }

    public function permissionerApproval(Request $request, $type, $id){
        if($type == 1){
            $result = $this->approveExit($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
            // echo $result;
            return redirect('approval')->with('status', $status);
        }elseif($type == 2){
            $result = $this->approveLeave($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
            // echo $result;
            return redirect('approval')->with('status', $status);
        }elseif($type == 3){
            $result = $this->approveChange($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }

            return redirect('approval')->with('status', $status);
        }elseif($type == 4){
            $result = $this->approveOvertime($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
            // echo $result;
            return redirect('approval')->with('status', $status);
        }else{
            $status = "Nothing to Show.";
            return redirect('approval')->with('status', $status);
        }
    }

    public function approveExit(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        // dd($data);
        if(isset($data['permission_1'])){
            if($data['permission_1'] == 2){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_1' => $data['permission_1'],
                                    'reason' => $data['note'],
                                    'updated_at' => $dateUpdate,
                                    'status' => 2
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_1 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_1'] == 1){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_1' => $data['permission_1'],
                                    'reason' => '',
                                    'status' => 0,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_1 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'note' => '', 'status' => 0]);
            }
        }elseif(isset($data['permission_2'])){
            if($data['permission_2'] == 2){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_2' => $data['permission_2'],
                                    'reason' => $data['note'],
                                    'status' => 2,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_2 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_2'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_2'] == 1){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_2' => $data['permission_2'],
                                    'reason' => '',
                                    'status' => 0,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_2 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_2'],
                //                     'id' => $id, 'note' => '', 'status' => 0]);
            }
        }elseif(isset($data['permission_3'])){
            if($data['permission_3'] == 2){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_3' => $data['permission_3'],
                                    'reason' => $data['note'],
                                    'status' => 2,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_3 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_3'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_3'] == 1){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_3' => $data['permission_3'],
                                    'reason' => '',
                                    'status' => 0,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_3 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_3'],
                //                     'id' => $id, 'note' => '', 'status' => 0]);
            }
        }elseif(isset($data['permission_4'])){
            if($data['permission_4'] == 2){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_4' => $data['permission_4'],
                                    'reason' => $data['note'],
                                    'status' => 2,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_4 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_4'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_4'] == 1){
                return ExitPass::where('id', $id)
                                ->update(array(
                                    'permission_4' => $data['permission_4'],
                                    'reason' => '',
                                    'status' => 1,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_epform SET permission_4 = :answer, exitNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE tbl_epid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_4'],
                //                     'id' => $id, 'note' => '', 'status' => 1]);
            }
        }
    }

    public function approveLeave(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        $contents = Leaves::where('id', $id)->get();
        if(isset($data['permission_1'])){
            if($data['permission_1'] == 2){
                return Leaves::where('id', $id)
                              ->update(array(
                                    'permission_1' => $data['permission_1'],
                                    'reason' => $data['note'],
                                    'status' => 2,
                                    'updated_at' => $dateUpdate
                                ));
                // return DB::update("UPDATE tbl_leave SET permission_1 = :answer, requestNote = :note, status = :status, dateUpdated = :dateUpdated
                //                     WHERE tbl_leaveid = :id", ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'status' => 2, 'note' => $data['note']]);
            }elseif($data['permission_1'] == 1){
                return Leaves::where('id', $id)
                             ->update(array(
                                'permission_1' => $data['permission_1'],
                                'reason' => '',
                                'status' => 0,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_leave SET permission_1 = :answer, requestNote = :note, status = :status, dateUpdated = :dateUpdated
                //                     WHERE tbl_leaveid = :id", ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'status' => 0, 'note' => '']);
            }
        }elseif(isset($data['permission_2'])){
            if($data['permission_2'] == 2){
                return Leaves::where('id', $id)
                             ->update(array(
                                'permission_2' => $data['permission_2'],
                                'reason' => $data['note'],
                                'status' => 2,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_leave SET permission_2 = :answer, requestNote = :note, status = :status, dateUpdated = :dateUpdated
                //                     WHERE tbl_leaveid = :id", ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_2'],
                //                     'id' => $id, 'status' => 2, 'note' => $data['note']]);
            }elseif($data['permission_2'] == 1){
                if(isset($data['VLDays'])){
                    foreach ($contents as $content) {
                        $user = User::where('id', $content->users->id)
                                    ->update(array(
                                        'VL_taken' => $data['VLDays']
                                    ));
                    }
                    return Leaves::where('id', $id)
                                 ->update(array(
                                    'permission_2' => $data['permission_2'],
                                    'reason' => '',
                                    'status' => 1,
                                    'updated_at' => $dateUpdate
                                ));  
                }elseif(isset($data['SLDays'])){
                    foreach ($contents as $content) {
                        $user = User::where('id', $content->users->id)
                                    ->update(array(
                                        'SL_taken' => $data['SLDays']
                                    ));
                    }
                    return Leaves::where('id', $id)
                                 ->update(array(
                                    'permission_2' => $data['permission_2'],
                                    'reason' => '',
                                    'status' => 1,
                                    'updated_at' => $dateUpdate
                                )); 
                }elseif(isset($data['MLDays'])){
                    foreach ($contents as $content) {
                        $user = User::where('id', $content->users->id)
                                    ->update(array(
                                        'ML_taken' => $data['MLDays']
                                    ));
                    }
                    return Leaves::where('id', $id)
                                 ->update(array(
                                    'permission_2' => $data['permission_2'],
                                    'reason' => '',
                                    'status' => 1,
                                    'updated_at' => $dateUpdate
                                )); 
                }elseif(isset($data['PLDays'])){
                    foreach ($contents as $content) {
                        $user = User::where('id', $content->users->id)
                                    ->update(array(
                                        'PL_taken' => $data['PLDays']
                                    ));
                    }
                    return Leaves::where('id', $id)
                                 ->update(array(
                                    'permission_2' => $data['permission_2'],
                                    'reason' => '',
                                    'status' => 1,
                                    'updated_at' => $dateUpdate
                                )); 
                }
                // foreach ($contents as $content) {
                //     echo $content->users->emp_name;
                // }
                // dd($contents);
                // return Leaves::where('id', $id)
                //              ->update(array(
                //                 'permission_2' => $data['permission_2'],
                //                 'reason' => '',
                //                 'status' => 1,
                //                 'updated_at' => $dateUpdate
                //             ));
                // dd($data);
                // return DB::update("UPDATE tbl_leave SET permission_2 = :answer, requestNote = :note, status = :status,
                //                     dateUpdated = :dateUpdated WHERE tbl_leaveid = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_2'], 
                //                     'id' => $id, 'status' => 1, 'note' => '']);
            }
        }
    }

    public function approveChange(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        // dd($data);
        if(isset($data['permission_1'])){
            if($data['permission_1'] == 2){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_1' => $data['permission_1'],
                                'reason' => $data['note'],
                                'status' => 2,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_1 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_1'] == 1){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_1' => $data['permission_1'],
                                'reason' => '',
                                'status' => 0,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_1 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'note' => '', 'status' => 0]);
            }
        }elseif(isset($data['permission_2'])){
            if($data['permission_2'] == 2){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_2' => $data['permission_2'],
                                'reason' => $data['note'],
                                'status' => 2,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_2 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_2'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_2'] == 1){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_2' => $data['permission_2'],
                                'reason' => '',
                                'status' => 0,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_2 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_2'],
                //                     'id' => $id, 'note' => '', 'status' => 0]);
            }
        }elseif(isset($data['permission_3'])){
            if($data['permission_3'] == 2){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_3' => $data['permission_3'],
                                'reason' => $data['note'],
                                'status' => 2,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_3 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_3'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_3'] == 1){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_3' => $data['permission_3'],
                                'reason' => '',
                                'status' => 0,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_3 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_3'],
                //                     'id' => $id, 'note' => '', 'status' => 0]);
            }
        }elseif(isset($data['permission_4'])){
            if($data['permission_4'] == 2){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_4' => $data['permission_4'],
                                'reason' => $data['note'],
                                'status' => 2,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_4 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_4'],
                //                     'id' => $id, 'note' => $data['note'], 'status' => 2]);
            }elseif($data['permission_4'] == 1){
                return Change::where('id', $id)
                             ->update(array(
                                'permission_4' => $data['permission_4'],
                                'reason' => '',
                                'status' => 1,
                                'updated_at' => $dateUpdate
                            ));
                // return DB::update("UPDATE tbl_chgschd SET permission_4 = :answer, changeNote = :note, 
                //                     dateUpdated = :dateUpdated, status = :status WHERE chgschd_id = :id", 
                //                     ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_4'],
                //                     'id' => $id, 'note' => '', 'status' => 1]);
            }
        }
    }


    public function approveOvertime(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        if(isset($data['permission_1'])){
            if($data['permission_1'] == 2){
                return Overtime::where('id', $id)
                              ->update(array(
                                    'permission_1' => $data['permission_1'],
                                    'reason' => $data['note'],
                                    'status' => 2,
                                    'updated_at' => $dateUpdate,
                                    'client_paid' => 0
                                ));
                // return DB::update("UPDATE tbl_leave SET permission_1 = :answer, requestNote = :note, status = :status, dateUpdated = :dateUpdated
                //                     WHERE tbl_leaveid = :id", ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'status' => 2, 'note' => $data['note']]);
            }elseif($data['permission_1'] == 1){
                return Overtime::where('id', $id)
                             ->update(array(
                                'permission_1' => $data['permission_1'],
                                'reason' => '',
                                'status' => 1,
                                'updated_at' => $dateUpdate,
                                'client_paid' => $data['client_paid']
                            ));

                // return DB::update("UPDATE tbl_leave SET permission_1 = :answer, requestNote = :note, status = :status, dateUpdated = :dateUpdated
                //                     WHERE tbl_leaveid = :id", ['dateUpdated' => $dateUpdate, 'answer' => $data['permission_1'],
                //                     'id' => $id, 'status' => 0, 'note' => '']);
            }
        }

        return Overtime::where('id', $id)
                            ->update(array(
                                'client_paid' => $data['client_paid'],
                                'updated_at' => $dateUpdate
                            ));
    }
}
