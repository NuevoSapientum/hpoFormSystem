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
use App\DateTimeOvertime;
use DateTime;
use App\Shifts;

class FormController extends Controller
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
        $count = $this->forms();
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
                    'empDepartment' => $empDepartment,
                    'count' => $count
        );
        return view('exitForm')->with($data);
    }

    public function postexitForm(Request $request){
        $rules = array('dateFrom' => 'required',
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
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        $count = $this->forms();
        $newFormatdateFrom = date('Y-m-d H:i:s', strtotime($dateFrom));
        $newFormatdateTo = date('Y-m-d H:i:s', strtotime($dateTo));

        $newFormattimeFrom = date('H:i:s', strtotime($dateFrom));
        $newFormattimeTo = date('H:i:s', strtotime($dateTo));

        if($newFormattimeTo - $newFormattimeFrom > 5){
          $status = "You are execeeded from your maximum hours to Exit!";
        }else{
          $exitPass = new ExitPass(array(
              'user_id' => $id,
              'created_at' => $request->input('dateCreated'),
              'date_from' => $newFormatdateFrom,
              'date_to' => $newFormatdateTo,
              'purpose' => $request->input('purpose'),
              'updated_at' => $dateUpdate,
              'department_id' => $department->id,
              'permission_id1' => $request->input('supervisor'),
              'permission_id2' => $request->input('projectManager'),
              'permission_id3' => $request->input('HR'),
              'permission_id4' => $request->input('companyRep'),
              'count' => $count
          ));

          $save = $exitPass->save();

          if($save){
              $status = "Success!";
          }else{
              $status = "Failed!";
          }
        }


        return redirect('/inbox')->with('status', $status);
    }

    /*Request for Leave of Absence Form Functions*/

    public function requestForLeave(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $HRs = DB::table("positions")
                ->join('users', 'users.position_id', '=', 'positions.id')
                ->where('positions.departments_id', 8)
                ->get();
        $Supervisors = User::where('permissioners', 1)->get();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $count = $this->forms();
        $data = array(
                    'title' => 'Request for Leave of Absence',
                    'positions' => $positions,
                    'HRs' => $HRs,
                    'Supervisors' => $Supervisors,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'count' => $count
            );

        return view('requestForLeave')->with($data);
    }

    public function postrequestForLeave(Request $request){
        $rules = array('typeofLeave' => 'required',
                       'startDate' => 'required',
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
        if($request->input('typeofLeave') == 1){
            $days_taken = Auth::user()->VL_taken + $request->input('VL_daysApplied');
            $balance = Auth::user()->VL_entitlement - Auth::user()->VL_taken;
            if($balance != 0){
                if($days_taken <= Auth::user()->VL_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    $requestAdd = new Leaves(array(
                        'user_id' => $id,
                        'leave_type' => $request->input('typeofLeave'),
                        'purpose' => $request->input('reasonforAbsence'),
                        'department_id' => $department->id,
                        'permission_id1' => $request->input('recommendApproval'),
                        'permission_id2' => $request->input('approvedBy'),
                        'days_applied' => $request->input('VL_daysApplied'),
                        'start_date' => $request->input('startDate'),
                        'updated_at' => $dateUpdate
                    ));

                    $save = $requestAdd->save();
                    if($save){
                        $status = "Success!";
                    }else{
                       $status = "Failed!";
                    }
                }else{
                    $status = "Failed!";
                }
            }else{
                $status = "You don't have any days of leave left.";
            }

        }elseif($request->input('typeofLeave') == 2){
            $days_taken = Auth::user()->SL_taken + $request->input('SL_daysApplied');
            $balance = Auth::user()->SL_entitlement - Auth::user()->SL_taken;
            if($balance != 0){
                if($days_taken <= Auth::user()->SL_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    $requestAdd = new Leaves(array(
                        'user_id' => $id,
                        'leave_type' => $request->input('typeofLeave'),
                        'purpose' => $request->input('reasonforAbsence'),
                        'department_id' => $department->id,
                        'permission_id1' => $request->input('recommendApproval'),
                        'permission_id2' => $request->input('approvedBy'),
                        'days_applied' => $request->input('SL_daysApplied'),
                        'start_date' => $request->input('startDate'),
                        'updated_at' => $dateUpdate
                    ));

                    $save = $requestAdd->save();
                    if($save){
                        $status = "Success!";
                    }else{
                       $status = "Failed!";
                    }
                }else{
                    $status = "Failed!";
                }
            }else{
                $status = "You don't have any days of leave left.";
            }
        }elseif($request->input('typeofLeave') == 3){
            $days_taken = Auth::user()->ML_taken + $request->input('ML_daysApplied');
            $balance = Auth::user()->ML_entitlement - Auth::user()->ML_taken;
            if($balance != 0){
                if($days_taken <= Auth::user()->ML_entitlement){
                    // Auth::user()->ML_taken = $days_taken;
                    // Auth::user()->save();
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    $requestAdd = new Leaves(array(
                        'user_id' => $id,
                        'leave_type' => $request->input('typeofLeave'),
                        'purpose' => $request->input('reasonforAbsence'),
                        'department_id' => $department->id,
                        'permission_id1' => $request->input('recommendApproval'),
                        'permission_id2' => $request->input('approvedBy'),
                        'days_applied' => $request->input('ML_daysApplied'),
                        'start_date' => $request->input('startDate'),
                        'updated_at' => $dateUpdate
                    ));

                    $save = $requestAdd->save();
                    if($save){
                        $status = "Success!";
                    }else{
                       $status = "Failed!";
                    }
                }else{
                    $status = "Failed!";
                }
            }else{
                $status = "You don't have any days of leave left.";
            }
        }elseif($request->input('typeofLeave') == 4){
            $days_taken = Auth::user()->PL_taken + $request->input('PL_daysApplied');
            $balance = Auth::user()->PL_entitlement - Auth::user()->PL_taken;
            if($balance != 0){
                if($days_taken <= Auth::user()->PL_entitlement){
                    $department = Positions::find(Auth::user()->position_id)->departments;
                    $requestAdd = new Leaves(array(
                        'user_id' => $id,
                        'leave_type' => $request->input('typeofLeave'),
                        'purpose' => $request->input('reasonforAbsence'),
                        'department_id' => $department->id,
                        'permission_id1' => $request->input('recommendApproval'),
                        'permission_id2' => $request->input('approvedBy'),
                        'days_applied' => $request->input('PL_daysApplied'),
                        'start_date' => $request->input('startDate'),
                        'updated_at' => $dateUpdate
                    ));

                    $save = $requestAdd->save();
                    if($save){
                        $status = "Success!";
                    }else{
                       $status = "Failed!";
                    }
                }else{
                    $status = "Failed!";
                }
            }else{
                $status = "You don't have any days of leave left.";
            }
        }
        // dd($request->all());
        return redirect('/inbox')->with('status', $status);
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
        $currentShift = Shifts::where('id', Auth::user()->shift_id)->get();
        foreach ($currentShift as $cur) {
            $currentShift = date('h:i A', strtotime($cur->shift_from)) . ' to ' . date('h:i A', strtotime($cur->shift_to));
        }

        $shifts = Shifts::all();
        $count = $this->forms();
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
                    'empDepartment' => $empDepartment,
                    'shifts' => $shifts,
                    'currentShift' => $currentShift,
                    'count' => $count
            );
        return view('changeSchedule')->with($data);
    }

    public function postchangeSchedule(Request $request){
        $rules = array('dateFromShift' => 'required',
                       'dateToShift' => 'required',
                       'shiftSchedule' => 'required',
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

        $department = Positions::find(Auth::user()->position_id)->departments;

        $dateFromShift = strtotime($request->input('dateFromShift'));
        $dateToShift = strtotime($request->input('dateToShift'));

        $dateToday = strtotime(date("Y-m-d"));

        if($dateFromShift > $dateToday){
            if($dateToShift < $dateFromShift){
                $status = "Please Double Check The Dates";
            }else{
                $change = new Change(array(
                            'user_id' => Auth::user()->id,
                            'shift_id' => $request->input('shiftSchedule'),
                            'dateFromShift' => $request->input('dateFromShift'),
                            'dateToShift' => $request->input('dateToShift'),
                            'department_id' => $department->id,
                            'permission_id1' => $request->input('supervisor'),
                            'permission_id2' => $request->input('projectManager'),
                            'permission_id3' => $request->input('permissioner'),
                            'permission_id4' => $request->input('HR'),
                            'purpose' => $request->input('reasonforChangeSchedule')
                ));
                $result = $change->save();

                if($result){
                  $status = "Success!";
                }else{
                  $status = "Failed!";
                }
            }
        }else{
            $status = "Please Double Check the Dates";
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
        $num = 1;
        $Supervisors = User::where('permissioners', 1)->get();
        $count = $this->forms();
        $data = array(
                    'title' => 'Overtime Authorization Slip',
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment,
                    'Supervisors' => $Supervisors,
                    'num' => $num,
                    'count' => $count
            );
        return view('overtimeAuthSlip')->with($data);
    }

    public function postovertimeAuthSlip(Request $request){
        // $rules = array('purpose' => 'required',
        //                'supervisor' => 'required',
        //                'dateFromOvertime' => 'required',
        //                'timeFromOvertime' => 'required',
        //                'dateToOvertime' => 'required',
        //                'timeToOvertime' => 'required');

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {
        //     $this->throwValidationException(
        //         $request, $validator
        //     );
        // }

        // dd($request->all());

        $department = Positions::find(Auth::user()->position_id)->departments;
        $dateFromOvertime = strtotime($request->input('dateFromOvertime'));
        $timeFromOvertime = strtotime($request->input('timeFromOvertime'));
        $dateToOvertime = strtotime($request->input('dateToOvertime'));
        $timeToOvertime = strtotime($request->input('timeToOvertime'));
        $user_shift = Shifts::find(Auth::user()->shift_id);
        $daysTotal = 0;
        $hoursTotal = 0;
        $minutesTotal = 0;
        $secondsTotal = 0;
        // dd($user_shift);

        $dateToday = strtotime(date("Y-m-d"));

        if($dateFromOvertime >= $dateToday && $dateToOvertime >= $dateFromOvertime){
            
            if(strtotime($request->input('timeFromOvertime')) >= strtotime($user_shift->shift_to)){
                $i = 1;
                $var = $request->input('number');
                if($var > 1){
                    $seconds = strtotime($request->input('dateToOvertime') . $request->input('timeToOvertime')) - strtotime($request->input('dateFromOvertime') . $request->input('timeFromOvertime'));

                    $days    = floor($seconds / 86400);
                    $hours   = floor(($seconds - ($days * 86400)) / 3600);
                    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                    $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
                    
                    $daysTotal = $days;
                    $hoursTotal = $hours;
                    $minutesTotal = $minutes;
                    $secondsTotal = $seconds;

                    $overtime_id = Overtime::insertGetId(
                                        ['user_id' => Auth::user()->id,
                                        'department_id' => $department->id,
                                        'purpose' => $request->input('purpose'),
                                        'permission_id1' => $request->input('supervisor')]
                        );

                    $firstdateTime = new DateTimeOvertime(array(
                                    'user_id' => Auth::user()->id,
                                    'dateFromOvertime' => $request->input('dateFromOvertime'),
                                    'timeFromOvertime' => $request->input('timeFromOvertime'),
                                    'dateToOvertime' => $request->input('dateToOvertime'),
                                    'timeToOvertime' => $request->input('timeToOvertime'),
                                    'overtime_id' => $overtime_id
                    ));
                    if($firstdateTime->save()){
                        while ($var != 0) {
                        
                            if($request->input('dateFromOvertime' . $i) != '' && $request->input('dateToOvertime' . $i) != ''
                                && $request->input('timeFromOvertime' . $i) != '' && $request->input('timeFromOvertime' . $i) != ''){
                                $seconds = strtotime($request->input('dateToOvertime' . $i) . $request->input('timeToOvertime' . $i)) - strtotime($request->input('dateFromOvertime' . $i) . $request->input('timeFromOvertime' . $i));

                                $days    = floor($seconds / 86400);
                                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                                $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                                $daysTotal += $days;
                                $hoursTotal += $hours;
                                $minutesTotal += $minutes;
                                $secondsTotal += $seconds;

                                $overtimeDatesTime = new DateTimeOvertime(array(
                                                'user_id' => Auth::user()->id,
                                                'dateFromOvertime' => $request->input('dateFromOvertime'),
                                                'timeFromOvertime' => $request->input('timeFromOvertime'),
                                                'dateToOvertime' => $request->input('dateToOvertime'),
                                                'timeToOvertime' => $request->input('timeToOvertime'),
                                                'overtime_id' => $overtime_id
                                ));

                                $overtimeDatesTime->save();

                            }

                            $var--;
                            $i++;
                        }

                        if($minutesTotal == 0){
                            $overtime = ($daysTotal*24) + $hoursTotal . ':00';
                        }elseif($minutesTotal >  0 && $minutesTotal < 10){
                            $overtime = ($daysTotal*24) + $hoursTotal . ':0' . $minutesTotal;
                        }else{
                            $overtime = ($daysTotal*24) + $hoursTotal . ':' . $minutesTotal;
                        }

                        $updateOvertime = Overtime::where('id', $overtime_id)
                                              ->update(array(
                                                'total_overtime' => $overtime
                                        ));
                        if($updateOvertime){
                            $status = "Success!";
                        }else{
                            $status = "Failed!";
                        }

                    }
                    // $status = "Failed!";
                    // echo $overtime;
                }else{
                    if($dateToOvertime > $dateFromOvertime){
                        $seconds = strtotime($request->input('dateToOvertime') . $request->input('timeToOvertime')) - strtotime($request->input('dateFromOvertime') . $request->input('timeFromOvertime'));

                        $days    = floor($seconds / 86400);
                        $hours   = floor(($seconds - ($days * 86400)) / 3600);
                        $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                        $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
                        // $day = $days*24;
                        if($minutes == 0){
                            $overtime = ($days*24) + $hours . ':00';
                        }elseif($minutes >  0 && $minutes < 10){
                            $overtime = ($days*24) + $hours . ':0' . $minutes;
                        }else{
                            $overtime = ($days*24) + $hours . ':' . $minutes;
                        }
                        
                        $overtime_id = Overtime::insertGetId(
                                        ['user_id' => Auth::user()->id,
                                        'department_id' => $department->id,
                                        'total_overtime' => $overtime,
                                        'purpose' => $request->input('purpose'),
                                        'permission_id1' => $request->input('supervisor')]
                        );

                        $firstdateTime = new DateTimeOvertime(array(
                                        'user_id' => Auth::user()->id,
                                        'dateFromOvertime' => $request->input('dateFromOvertime'),
                                        'timeFromOvertime' => $request->input('timeFromOvertime'),
                                        'dateToOvertime' => $request->input('dateToOvertime'),
                                        'timeToOvertime' => $request->input('timeToOvertime'),
                                        'overtime_id' => $overtime_id
                        ));

                        $firstdateTime->save();

                        if($firstdateTime){
                            $status = "Success!";
                        }else{
                            $status = "Failed!";
                        }
                    }elseif($dateToOvertime == $dateFromOvertime){
                        if($timeToOvertime > $timeFromOvertime){
                            $to_time = strtotime(date('Y-m-d', $dateToOvertime) . date(' H:i:s', $timeToOvertime));
                            $from_time = strtotime(date('Y-m-d', $dateFromOvertime) . date(' H:i:s', $timeFromOvertime));
                            $minutes = round(abs($to_time - $from_time) / 60,2);
                            $seconds = abs($to_time - $from_time) % 60;
                            $overtime = gmdate("H:i", ($minutes * 60));

                            $overtime_id = Overtime::insertGetId(
                                            ['user_id' => Auth::user()->id,
                                            'department_id' => $department->id,
                                            'total_overtime' => $overtime,
                                            'purpose' => $request->input('purpose'),
                                            'permission_id1' => $request->input('supervisor')]
                            );

                            $firstdateTime = new DateTimeOvertime(array(
                                            'user_id' => Auth::user()->id,
                                            'dateFromOvertime' => $request->input('dateFromOvertime'),
                                            'timeFromOvertime' => $request->input('timeFromOvertime'),
                                            'dateToOvertime' => $request->input('dateToOvertime'),
                                            'timeToOvertime' => $request->input('timeToOvertime'),
                                            'overtime_id' => $overtime_id
                            ));

                            $firstdateTime->save();

                            if($firstdateTime){
                                $status = "Success!";
                            }else{
                                $status = "Failed!";
                            }
                        }else{
                            $status = "Error: Double Check your Time inputted";
                            // echo $status;
                        }
                        
                    }
                }
            }else{
                $status = "Error: Double Check your Time inputted";
                // echo "2";
            }
        }else{
            $status = "Error: Double Check your Date inputted";
        }

            // dd($request->all());
            
        

        return redirect('inbox')->with('status', $status);
        // dd($request->all());
    }

}
