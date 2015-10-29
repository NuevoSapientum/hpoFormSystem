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
use App\Shifts;

class InboxController extends Controller
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

    public function inbox(){
        $profileImage = $this->getImage();
        $exitPass = ExitPass::where('user_id', Auth::user()->id)
                            ->where('status', 0)
                            ->get();
        $leaveForm = Leaves::where('user_id', Auth::user()->id)
                            ->where('status', 0)
                            ->get();
        $changeSchedule = Change::where('user_id', Auth::user()->id)
                            ->where('status', 0)
                            ->get();
        $oas = Overtime::where('user_id', Auth::user()->id)
                    ->where('status', 0)
                    ->get();
        $users = DB::table('positions')
                ->join('users', 'users.position_id', '=', 'positions.id')
                ->get();
        $positions = $this->position();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $count = $this->forms();
        $data = array(
                    'title' => 'Inbox',
                    'profileImage' => $profileImage,
                    'positions' => $positions,
                    'exitPass' => $exitPass,
                    'users' => $users,
                    'leaveForm' => $leaveForm,
                    'changeSchedule' => $changeSchedule,
                    'oas' => $oas,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'count' => $count
                    );
        // dd($exitPass);
        return view('user.inbox')->with($data);
    }

    public function editForm($type, $id){
        $inboxNotif = $this->inboxNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $approvalNotif = $this->approvalNotif();
        $count = $this->forms();
        $dataFirst = array(
                    'inboxNotif' => $inboxNotif,
                    'profileImage' => $profileImage,
                    'positions' => $positions,
                    'approvalNotif' => $approvalNotif,
                    'count' => $count
            );
        if($type == 1){
            $contents = ExitPass::where('id', $id)
                        ->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $HRs = DB::table("positions")
                    ->join('users', 'users.position_id', '=', 'positions.id')
                    ->where('positions.department_id', 1)
                    ->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $PMs = User::where('permissioners', 2)->get();
            $CompanyReps = User::where('permissioners', 3)->get();
            $dataSecond = array(
                        'title' => "Edit Exit Pass",
                        'contents' => $contents,
                        'HRs' => $HRs,
                        'Supervisors' => $Supervisors,
                        'PMs' => $PMs,
                        'CompanyReps' => $CompanyReps,
                        'empDepartment' => $empDepartment
                );
            $data = array_merge($dataFirst, $dataSecond);
            // dd($contents);
            foreach ($contents as $content) {
                if($content->permission_1 != 0 || $content->status == 1){
                    return view('user.inboxExitApproval')->with($data);
                }else{
                    return view('user.inboxExit')->with($data);
                }
            }

        }elseif($type == 2){
            $contents = Leaves::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            foreach ($contents as $content) {
                if($content->permission_1 != 0){
                    $HRs = DB::table("positions")
                            ->join('users', 'users.position_id', '=', 'positions.id')
                            ->where('positions.department_id', 1)
                            ->get();
                    $Supervisors = User::where('permissioners', 1)->get();
                    $dataSecond = array(
                                    'title' => "Edit Request for Leave of Absence",
                                    'contents' => $contents,
                                    'HRs' => $HRs,
                                    'Supervisors' => $Supervisors,
                                    'empDepartment' => $empDepartment
                        );
                    $data = array_merge($dataFirst, $dataSecond);
                    // dd($contents);
                    return view('user.inboxLeaveApproval')->with($data);
                }else{
                    $HRs = DB::table("positions")
                            ->join('users', 'users.position_id', '=', 'positions.id')
                            ->where('positions.department_id', 1)
                            ->get();
                    $Supervisors = User::where('permissioners', 1)->get();
                    $dataSecond = array(
                                    'title' => "Edit Request for Leave of Absence",
                                    'contents' => $contents,
                                    'HRs' => $HRs,
                                    'Supervisors' => $Supervisors,
                                    'empDepartment' => $empDepartment
                        );
                    $data = array_merge($dataFirst, $dataSecond);
                    return view('user.inboxLeave')->with($data);
                }
            }
        }elseif($type == 3){
            $contents = Change::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $HRs = DB::table("positions")
                    ->join('users', 'users.position_id', '=', 'positions.id')
                    ->where('positions.department_id', 1)
                    ->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $PMs = User::where('permissioners', 2)->get();
            $CompanyReps = User::where('permissioners', 3)->get();
            $currentShift = Shifts::where('id', Auth::user()->shift_id)->get();
            foreach ($currentShift as $cur) {
                $currentShift = date('h:i A', strtotime($cur->shift_from)) . ' to ' . date('h:i A', strtotime($cur->shift_to));
            }
            $shifts = Shifts::all();
            $dataSecond = array(
                                    'title' => "Edit Change Schedule",
                                    'contents' => $contents,
                                    'permissioners' => $permissioners,
                                    'HRs' => $HRs,
                                    'Supervisors' => $Supervisors,
                                    'PMs' => $PMs,
                                    'CompanyReps' => $CompanyReps,
                                    'empDepartment' => $empDepartment,
                                    'currentShift' => $currentShift,
                                    'shifts' => $shifts
                        );
            $data = array_merge($dataFirst, $dataSecond);
            foreach ($contents as $content) {
                if($content->permission_1 != 0){
                    return view('user.inboxChangeApproval')->with($data);
                }else{
                    return view('user.inboxChange')->with($data);
                }
            }
        }elseif($type == 4){
            $contents = Overtime::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $Supervisors = User::where('permissioners', 1)->get();
            $dateTime = DateTimeOvertime::where('overtime_id', $id)->get();
            $var = 0;
            $shift = Shifts::find(Auth::user()->shift_id);
            $dataSecond = array(
                            'title' => "Edit Overtime Authorization",
                            'contents' => $contents,
                            'empDepartment' => $empDepartment,
                            'Supervisors' => $Supervisors,
                            'dateTime' => $dateTime,
                            'var' => $var,
                            'shift' => $shift
                );
            $data = array_merge($dataFirst, $dataSecond);

            foreach ($contents as $content) {
                if($content->permission_1 != 0){
                    return view('user.inboxOverApproval')->with($data);
                }else{
                    return view('user.inboxOver')->with($data);
                }
            }

            // dd($data);
        }else{
            $status = "Nothing to Show.";
            return redirect('inbox')->with('status', $status);
        }

    }

    public function postForm(Request $request, $type, $id){
        if($type == 1){
            $result = $this->editExit($request->all(), $id);
            // echo $result;
            if($result == 1){
                $status = "Success!";
            }elseif($result == "You are execeeded from your maximum hours to Exit!"){
                $status = "You are execeeded from your maximum hours to Exit!";
            }else{
                $status = "Failed!";
            }
            return redirect('inbox')->with('status', $status);
        }elseif($type == 2){
            $result = $this->editLeave($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
            // echo $result;
            return redirect('inbox')->with('status', $status);
        }elseif($type == 3){
            $result = $this->editChange($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
            return redirect('inbox')->with('status', $status);
        }elseif($type == 4){
            $result = $this->editOver($request->all(), $id);
            if($result){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
            return redirect('inbox')->with('status', $status);
        }
    }

    public function deleteForm($type, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        if($type == 1){
            $contents = ExitPass::where('id', $id)->get();
            foreach ($contents as $content) {
                if($content->permission_1 === 1 || $content->permission_1 === 2 ){
                    $status = "Failed!";
                }else{
                    $result = ExitPass::where('id', $id)
                        ->update(array(
                        'status' => 3,
                        'updated_at' => $dateUpdate));
                    if($result)
                        $status = "Success!";
                    else
                        $status = "Failed!";
                }
            }
            return redirect('inbox')->with('status', $status);
        }elseif($type == 2){
            $contents = Leaves::where('id', $id)->get();
            foreach ($contents as $content) {
                if($content->permission_1 === 1 || $content->permission_1 === 2){
                    $status = "Failed!";
                }else{
                    $result = Leaves::where('id', $id)
                                    ->update(array(
                                    'status' => 3,
                                    'updated_at' => $dateUpdate
                                    ));
                    if($result)
                        $status = "Success!";
                    else
                        $status = "Failed!";
                }
            }

            return redirect('inbox')->with('status', $status);
        }elseif($type == 3){
            $contents = Change::where('id', $id)->get();
            foreach ($contents as $content) {
                if($content->permission_1 === 1 || $content->permission_1 === 2){
                    $status = "Failed!";
                }else{
                    $result = Change::where('id', $id)
                                    ->update(array(
                                    'status' => 3,
                                    'updated_at' => $dateUpdate
                                    ));
                    if($result)
                        $status = "Success!";
                    else
                        $status = "Failed!";
                }
            }

            return redirect('inbox')->with('status', $status);
        }elseif($type == 4){
            $result = Overtime::where('id', $id)
                            ->update(array(
                                'status' => 3,
                                'updated_at' => $dateUpdate
                            ));
            if($result)
                $status = "Success!";
            else
                $status = "Failed!";

            return redirect('inbox')->with('status', $status);
        }
    }

    public function viewForm($type, $id){
        $inboxNotif = $this->inboxNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $approvalNotif = $this->approvalNotif();
        $count = $this->forms();
        $dataFirst = array(
                    'inboxNotif' => $inboxNotif,
                    'profileImage' => $profileImage,
                    'positions' => $positions,
                    'approvalNotif' => $approvalNotif,
                    'count' => $count
            );
        if($type == 1){
            $contents = ExitPass::where('id', $id)
                        ->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $HRs = DB::table("positions")
                    ->join('users', 'users.position_id', '=', 'positions.id')
                    ->where('positions.department_id', 1)
                    ->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $PMs = User::where('permissioners', 2)->get();
            $CompanyReps = User::where('permissioners', 3)->get();
            $dataSecond = array(
                        'title' => "Edit Exit Pass",
                        'contents' => $contents,
                        'HRs' => $HRs,
                        'Supervisors' => $Supervisors,
                        'PMs' => $PMs,
                        'CompanyReps' => $CompanyReps,
                        'empDepartment' => $empDepartment
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxExitApproval')->with($data);
        }elseif($type == 2){
            $contents = Leaves::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $HRs = DB::table("positions")
                    ->join('users', 'users.position_id', '=', 'positions.id')
                    ->where('positions.department_id', 1)
                    ->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $dataSecond = array(
                                    'title' => "Edit Request for Leave of Absence",
                                    'contents' => $contents,
                                    'HRs' => $HRs,
                                    'Supervisors' => $Supervisors,
                                    'empDepartment' => $empDepartment
                        );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxLeaveApproval')->with($data);
        }elseif($type == 3){
            $contents = Change::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $HRs = DB::table("positions")
                    ->join('users', 'users.position_id', '=', 'positions.id')
                    ->where('positions.department_id', 1)
                    ->get();
            $Supervisors = User::where('permissioners', 1)->get();
            $PMs = User::where('permissioners', 2)->get();
            $CompanyReps = User::where('permissioners', 3)->get();
            $currentShift = Shifts::where('id', Auth::user()->shift_id)->get();
            $shifts = Shifts::all();
            foreach ($currentShift as $cur) {
                $currentShift = date('h:i A', strtotime($cur->shift_from)) . ' to ' . date('h:i A', strtotime($cur->shift_to));
            }
            $dataSecond = array(
                                    'title' => "Edit Change Schedule",
                                    'contents' => $contents,
                                    'permissioners' => $permissioners,
                                    'HRs' => $HRs,
                                    'Supervisors' => $Supervisors,
                                    'PMs' => $PMs,
                                    'CompanyReps' => $CompanyReps,
                                    'empDepartment' => $empDepartment,
                                    'currentShift' => $currentShift,
                                    'shifts' => $shifts
                        );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxChangeApproval')->with($data);
        }elseif($type == 4){
           $contents = Overtime::where('id', $id)->get();
            $user_position = Auth::user()->position_id;
            $empDepartment = Positions::find($user_position)->departments;
            $Supervisors = User::where('permissioners', 1)->get();
            $dateTime = DateTimeOvertime::where('overtime_id', $id)->get();
            $shift = Shifts::find(Auth::user()->shift_id);
            $var = 0;
            $dataSecond = array(
                            'title' => "Edit Overtime Authorization",
                            'contents' => $contents,
                            'empDepartment' => $empDepartment,
                            'Supervisors' => $Supervisors,
                            'dateTime' => $dateTime,
                            'var' => $var,
                            'shift' => $shift
                );
            $data = array_merge($dataFirst, $dataSecond);
            // dd($data);
            return view('user.inboxOverApproval')->with($data);
        }else{
            $status = "Nothing to Show.";
            return redirect('inbox')->with('status', $status);
        }
    }

    public function editExit(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        $dateFrom = $data['dateFrom'];
        $dateTo = $data['dateTo'];
        // echo $newDate;
        $newFormatdateFrom = date('Y-m-d H:i:s', strtotime($dateFrom));
        $newFormatdateTo = date('Y-m-d H:i:s', strtotime($dateTo));

        $newFormattimeFrom = date('H:i:s', strtotime($dateFrom));
        $newFormattimeTo = date('H:i:s', strtotime($dateTo));
        if($newFormattimeTo - $newFormattimeFrom > 5){
          return "You are execeeded from your maximum hours to Exit!";
        }else{
          return ExitPass::where('id', $id)
                          ->update(array(
                          'date_from' => $newFormatdateFrom,
                          'date_to' => $newFormatdateTo,
                          'purpose' => $data['textPurpose'],
                          'permission_id1' => $data['supervisor'],
                          'permission_id2' => $data['projectManager'],
                          'permission_id3' => $data['HR'],
                          'permission_id4' => $data['companyRep'],
                          'updated_at' => $dateUpdate));
        }

    }

    public function editLeave(array $data, $id){
        $datas = Leaves::where('id', $id)->get();

        $dateUpdate = date("Y-m-d H:i:s");
        if($data['typeofLeave'] == 1){
            if(isset($data['VL_daysApplied'])){
                $days_taken = Auth::user()->VL_taken + $data['VL_daysApplied'];
                if($days_taken <= Auth::user()->VL_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    return Leaves::where('id', $id)
                                ->update(array(
                                'leave_type' => $data['typeofLeave'],
                                'purpose' => $data['reasonforAbsence'],
                                'permission_id1' => $data['recommendApproval'],
                                'permission_id2' => $data['approvedBy'],
                                'days_applied' => $data['VL_daysApplied'],
                                'updated_at' => $dateUpdate
                                ));
                }
            }else{
                return false;
            }
            
        }else if($data['typeofLeave'] == 2){
            if(isset($data['SL_daysApplied'])){
                $days_taken = Auth::user()->SL_taken + $data['SL_daysApplied'];
                if($days_taken <= Auth::user()->SL_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    return Leaves::where('id', $id)
                                ->update(array(
                                'leave_type' => $data['typeofLeave'],
                                'purpose' => $data['reasonforAbsence'],
                                'permission_id1' => $data['recommendApproval'],
                                'permission_id2' => $data['approvedBy'],
                                'days_applied' => $data['SL_daysApplied'],
                                'updated_at' => $dateUpdate
                                ));
                }
            }else{
                return false;
            }
            
            // dd($data);
        }else if($data['typeofLeave'] == 3){     
            if(isset($data['ML_daysApplied'])){
                $days_taken = Auth::user()->ML_taken + $data['ML_daysApplied'];
                if($days_taken <= Auth::user()->ML_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    return Leaves::where('id', $id)
                                    ->update(array(
                                    'leave_type' => $data['typeofLeave'],
                                    'purpose' => $data['reasonforAbsence'],
                                    'permission_id1' => $data['recommendApproval'],
                                    'permission_id2' => $data['approvedBy'],
                                    'days_applied' => $data['ML_daysApplied'],
                                    'updated_at' => $dateUpdate
                                    ));
                }
            }else{
                return false;
            }
        }else if($data['typeofLeave'] == 4){
            if(isset($data['PL_daysApplied'])){
                $days_taken = Auth::user()->PL_taken + $data['PL_daysApplied'];
                if($days_taken <= Auth::user()->PL_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    return Leaves::where('id', $id)
                                ->update(array(
                                'leave_type' => $data['typeofLeave'],
                                'purpose' => $data['reasonforAbsence'],
                                'permission_id1' => $data['recommendApproval'],
                                'permission_id2' => $data['approvedBy'],
                                'days_applied' => $data['PL_daysApplied'],
                                'updated_at' => $dateUpdate
                                ));
                }
            }else{
                return false;
            }
        }
    }

    public function editChange(array $data, $id){

        $dateFromShift = strtotime($data['dateFromShift']);
        $dateToShift = strtotime($data['dateToShift']);

        $dateToday = strtotime(date("Y-m-d"));

        if($dateFromShift > $dateToday){
            if($dateToShift < $dateFromShift){
                return false;
            }else{
                 return Change::where('id', $id)
                                ->update(array(
                                'shift_id' => $data['shiftSchedule'],
                                'dateFromShift' => $data['dateFromShift'],
                                'dateToShift' => $data['dateToShift'],
                                'permission_id1' => $data['supervisor'],
                                'permission_id2' => $data['projectManager'],
                                'permission_id3' => $data['permissioner'],
                                'permission_id4' => $data['HR'],
                                'purpose' => $data['reasonforChangeSchedule']
                                ));
            }
        }else{
            return false;
        }
    }

    public function editOver(array $data, $id){
        // dd($data);
        $count = $data['count'];
        $daysTotal = 0;
        $hoursTotal = 0;
        $minutesTotal = 0;
        $secondsTotal = 0;
        $i = 1;
        // echo $count;
        // dd($data);
        while($count != 0){
            $seconds = strtotime($data['dateToOvertime' . $i] . $data['timeToOvertime' . $i]) - strtotime($data['dateFromOvertime' . $i] . $data['timeFromOvertime' . $i]);

            $days    = floor($seconds / 86400);
            $hours   = floor(($seconds - ($days * 86400)) / 3600);
            $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
            $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

            $daysTotal += $days;
            $hoursTotal += $hours;
            $minutesTotal += $minutes;
            $secondsTotal += $seconds;

            $dateTime = DateTimeOvertime::where('id', $data['id' . $i])
                                        ->update(array(
                                            'dateFromOvertime' => $data['dateFromOvertime' . $i],
                                            'timeFromOvertime' => $data['timeFromOvertime' . $i],
                                            'dateToOvertime' => $data['dateToOvertime' . $i],
                                            'timeToOvertime' => $data['timeToOvertime' . $i]
                                        ));
            // echo $daysTotal . '<br/>';
            // echo $hoursTotal . '<br/>';
            // echo $minutesTotal . '<br/>';
            // echo $data['dateFromOvertime'.$i] . '=' . $data['timeFromOvertime'.$i] . '<br/>';
            // echo $data['dateToOvertime'.$i] . '=' .$data['timeToOvertime' .$i] . '<br/>';
            // echo 'id: ' . $data['id'. $i];
            $i++;
            $count--;
        }

        if($minutesTotal == 0){
            $overtime = ($daysTotal*24) + $hoursTotal . ':00';
        }elseif($minutesTotal >  0 && $minutesTotal < 10){
            $overtime = ($daysTotal*24) + $hoursTotal . ':0' . $minutesTotal;
        }else{
            $overtime = ($daysTotal*24) + $hoursTotal . ':' . $minutesTotal;
        }

        // echo $overtime;
        return Overtime::where('id', $id)
                          ->update(array(
                                    'permission_id1' => $data['supervisor'],
                                    'purpose' => $data['purpose'],
                                    'total_overtime' => $overtime
                            ));
    }

}
