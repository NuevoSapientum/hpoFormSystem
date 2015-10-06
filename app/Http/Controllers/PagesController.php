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

    public function inboxNotif(){
        $exitPass = DB::select("SELECT * FROM tbl_epform WHERE id = :user_id AND status != 0", ['user_id' => Auth::user()->id]);
        $leaveForm = DB::select("SELECT * FROM tbl_leave WHERE id = :user_id AND status != 0", ['user_id' => Auth::user()->id]);
        $changeSchedule = DB::select("SELECT * FROM tbl_chgschd WHERE id = :user_id AND status != 0", ['user_id' => Auth::user()->id]);
        $oas = DB::select("SELECT * FROM tbl_oas WHERE id = :user_id AND status != 0", ['user_id' => Auth::user()->id]);
        return $inboxNotif = count($exitPass) + count($leaveForm) + count($changeSchedule) + count($oas);
    }


    public function approvalNotif(){
        $id = Auth::user()->id;
        $exitPass = DB::select("SELECT * FROM tbl_epform JOIN users ON tbl_epform.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2 OR permission_id3 = :id3
                            OR permission_id4 = :id4 AND status = :status", ['id1' => $id, 'id2' => $id, 'id3' => $id, 'id4' => $id, 'status' => 1]);
        $leaveForm = DB::select("SELECT * FROM tbl_leave JOIN users ON tbl_leave.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2
                            AND status = :status", ['id1' => $id, 'id2' => $id, 'status' => 1]);
        $changeSchedule = DB::select("SELECT * FROM tbl_chgschd JOIN users ON tbl_chgschd.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2 OR permission_id3 = :id3
                            OR permission_id4 = :id4 AND status = :status", ['id1' => $id, 'id2' => $id, 'id3' => $id, 'id4' => $id, 'status' => 1]);
        return count($exitPass) + count($leaveForm) + count($changeSchedule);
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
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $data = array(
                    'title' => 'Home',
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('dashboard')->with($data);
    }

    /**
    *Display the History Page
    *
    */
    public function history(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $data = array(
                    'title' => 'History',
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('history')->with($data);
    }

    public function inbox(){
        $profileImage = $this->getImage();
        $exitPass = DB::select("SELECT * FROM tbl_epform WHERE id = :user_id", ['user_id' => Auth::user()->id]);
        $leaveForm = DB::select("SELECT * FROM tbl_leave WHERE id = :user_id", ['user_id' => Auth::user()->id]);
        $changeSchedule = DB::select("SELECT * FROM tbl_chgschd WHERE id = :user_id", ['user_id' => Auth::user()->id]);
        $oas = DB::select("SELECT * FROM tbl_oas WHERE id = :user_id", ['user_id' => Auth::user()->id]);
        $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $positions = $this->position();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
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
                    'approvalNotif' => $approvalNotif
                    );
        return view('user.inbox')->with($data);
    }

    public function editInbox($type, $id){
        $inboxNotif = $this->inboxNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $approvalNotif = $this->approvalNotif();
        $dataFirst = array(
                    'inboxNotif' => $inboxNotif,
                    'profileImage' => $profileImage,
                    'positions' => $positions,
                    'approvalNotif' => $approvalNotif
            );
        if($type == 1){
            $contents = DB::select("SELECT * FROM tbl_epform WHERE tbl_epid = :id", ['id' => $id]);
            $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
            $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
            $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
            $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
            $dataSecond = array(
                        'title' => "Edit Exit Pass",
                        'contents' => $contents,
                        'HRs' => $HRs,
                        'Supervisors' => $Supervisors,
                        'PMs' => $PMs,
                        'CompanyReps' => $CompanyReps
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxExit')->with($data);
        }elseif($type == 2){
            $contents = DB::select("SELECT * FROM tbl_leave WHERE tbl_leaveid = :id", ['id' => $id]);
            $permissioners = DB::select("select * FROM users WHERE permissioners");
            $dataSecond = array(
                            'title' => "Edit Request for Leave of Absence",
                            'contents' => $contents,
                            'permissioners' => $permissioners
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxLeave')->with($data);
        }elseif($type == 3){
            $contents = DB::select("SELECT * FROM tbl_chgschd WHERE chgschd_id = :id", ['id' => $id]);
            $permissioners = DB::select("SELECT * FROM users WHERE permissioners");
            $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
            $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
            $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
            $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
            $dataSecond = array(
                            'title' => "Edit Change Schedule",
                            'contents' => $contents,
                            'permissioners' => $permissioners,
                            'HRs' => $HRs,
                            'Supervisors' => $Supervisors,
                            'PMs' => $PMs,
                            'CompanyReps' => $CompanyReps
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxChange')->with($data);
        }elseif($type == 4){
            $contents = DB::select("SELECT * FROM tbl_oas WHERE tbl_oasid = :id", ['id' => $id]);
            $dataSecond = array(
                            'title' => "Edit Change Schedule",
                            'contents' => $contents
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.inboxOver')->with($data);
        }else{
            $status = "Nothing to Show.";
            return redirect('inbox')->with('status', $status);
        }

    }

    public function postInbox(Request $request, $type, $id){
        if($type == 1){
            $result = $this->editExit($request->all(), $id);
            if($result){
                $status = "Success!";
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

    public function editExit(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        return DB::update("UPDATE `tbl_epform` SET `dateFROM` = :dateFrom, 
                            `dateTo` = :dateTo, `textPurpose` = :textPurpose, 
                            `permission_id1` = :permission_id1, `permission_id2` = :permission_id2,
                            `permission_id3` = :permission_id3, `permission_id4` = :permission_id4,
                            `dateUpdated` = :dateUpdated WHERE `tbl_epid` = :id", 
                            ['dateFrom' => $data['dateFrom'], 'dateTo' => $data['dateTo'],
                             'textPurpose' => $data['textPurpose'], 'permission_id1' => $data['supervisor'],
                             'permission_id2' => $data['projectManager'], 'permission_id3' => $data['HR'],
                             'permission_id4' => $data['companyRep'], 'dateUpdated' => $dateUpdate, 'id' => $id]);
    }

    public function editLeave(array $data, $id){
        Auth::user()->days_applied += $data['days_applied'];
        $dateUpdate = date("Y-m-d H:i:s");
        return DB::update("UPDATE `tbl_leave` SET `leave_type` = :typeofLeave,
                            `reason` = :reason, `permission_id1` = :recommendApproval,
                            `permission_id2` = :approvedBy, `days_applied` = :days_applied,
                            `dateUpdated` = :dateUpdated WHERE `tbl_leaveid` = :id",
                            ['typeofLeave' => $data['typeofLeave'], 'reason' => $data['reason'],
                            'recommendApproval' => $data['recommendApproval'], 'approvedBy' => $data['approvedBy'],
                            'days_applied' => $data['days_applied'], 'dateUpdated' => $dateUpdate, 'id' => $id]);
    }

    public function editChange(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        return DB::update("UPDATE tbl_chgschd SET date_from = :dateFromEffectivity, date_to = :dateToEffectivity,
                            shift_from = :dateFromShift, shift_to = :dateToShift, reason = :reason,
                            permission_id1 = :supervisor, permission_id2 = :projectManager, permission_id3 = :permissioner,
                            permission_id4 = :HR, dateUpdated = :dateUpdated WHERE chgschd_id = :id",
                            ['dateFromEffectivity' => $data['dateFromEffectivity'], 'dateToEffectivity' => $data['dateToEffectivity'],
                            'dateFromShift' => $data['dateFromShift'], 'dateToShift' => $data['dateToShift'],
                            'reason' => $data['reason'], 'supervisor' => $data['supervisor'], 'projectManager' => $data['projectManager'],
                            'permissioner' => $data['permissioner'], 'HR' => $data['HR'], 'dateUpdated' => $dateUpdate, 'id' => $id]);
    }    

    public function editOver(array $data, $id){
        $dateUpdate = date("Y-m-d H:i:s");
        return DB::update("UPDATE tbl_oas SET reason = :reason, client_id = :client_id, dateUpdated = :dateUpdated
                            WHERE tbl_oasid = :id", ['reason', $data['reason'], 'client_id', $data['client'], 
                            'dateUpdated' => $dateUpdate, 'id' => $id]);
    }


    /*---------------------------------------------------------------------Approval------------------------------------------------------*/

    public function exitApprovals($id){
        return DB::select("SELECT * FROM tbl_epform JOIN users ON tbl_epform.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2 OR permission_id3 = :id3
                            OR permission_id4 = :id4 AND status = :status", ['id1' => $id, 'id2' => $id, 'id3' => $id, 'id4' => $id, 'status' => 1]);
    }

    public function leaveApprovals($id){
        return DB::select("SELECT * FROM tbl_leave JOIN users ON tbl_leave.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2
            AND status = :status", ['id1' => $id, 'id2' => $id, 'status' => 1]);
    }

    public function changeApprovals($id){
        return DB::select("SELECT * FROM tbl_chgschd JOIN users ON tbl_chgschd.id = users.id WHERE permission_id1 = :id1 OR permission_id2 = :id2 OR permission_id3 = :id3
                            OR permission_id4 = :id4 AND status = :status", ['id1' => $id, 'id2' => $id, 'id3' => $id, 'id4' => $id, 'status' => 1]);
    }

    public function approval(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $exitApprovals = $this->exitApprovals(Auth::user()->id);
        $leaveApprovals = $this->leaveApprovals(Auth::user()->id);
        $changeApprovals = $this->changeApprovals(Auth::user()->id);
        $data = array(
                'title' => "Need Approvals",
                'inboxNotif' => $inboxNotif,
                'positions' => $positions,
                'profileImage' => $profileImage,
                'exitApprovals' => $exitApprovals,
                'leaveApprovals' => $leaveApprovals,
                'changeApprovals' => $changeApprovals,
                'approvalNotif' => $approvalNotif
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
            $contents = DB::select("SELECT * FROM tbl_epform WHERE tbl_epid = :id", ['id' => $id]);
            $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
            $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
            $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
            $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
            $dataSecond = array(
                        'title' => "Need Approval Edit Exit Pass",
                        'contents' => $contents,
                        'HRs' => $HRs,
                        'Supervisors' => $Supervisors,
                        'PMs' => $PMs,
                        'CompanyReps' => $CompanyReps
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.approvalExitView')->with($data);
        }elseif($type == 2){
            $contents = DB::select("SELECT * FROM tbl_leave WHERE tbl_leaveid = :id", ['id' => $id]);
            $permissioners = DB::select("select * FROM users WHERE permissioners");
            $dataSecond = array(
                            'title' => "Edit Request for Leave of Absence",
                            'contents' => $contents,
                            'permissioners' => $permissioners
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.approvalRequestView')->with($data);
        }elseif($type == 3){
            $contents = DB::select("SELECT * FROM tbl_chgschd WHERE chgschd_id = :id", ['id' => $id]);
            $permissioners = DB::select("SELECT * FROM users WHERE permissioners");
            $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
            $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
            $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
            $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
            $dataSecond = array(
                            'title' => "Edit Change Schedule",
                            'contents' => $contents,
                            'permissioners' => $permissioners,
                            'HRs' => $HRs,
                            'Supervisors' => $Supervisors,
                            'PMs' => $PMs,
                            'CompanyReps' => $CompanyReps
                );
            $data = array_merge($dataFirst, $dataSecond);
            return view('user.approvalChangeView')->with($data);
        }else{
            $status = "Nothing to Show.";
            return redirect('approval')->with('status', $status);
        }
    }

    /**
    *Display the Exit Pass Form Page
    *
    */
    public function exitForm(){
        $inboxNotif = $this->inboxNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $approvalNotif = $this->approvalNotif();
        $department = DB::select("SELECT department.* FROM `department` JOIN position ON position.position_id = :user_posid AND department.department_id = position.department_id", ['user_posid' => Auth::user()->position_id]);
        // $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
        $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
        $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
        $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
        $data = array(
                    'title' => 'Exit Pass',
                    'positions' => $positions,
                    'HRs' => $HRs,
                    'department_user' => $department,
                    'Supervisors' => $Supervisors,
                    'PMs' => $PMs,
                    'CompanyReps' => $CompanyReps,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('exitForm')->with($data);
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
        return redirect('/inbox');
    }


    public function deleteInbox($type, $id){
        if($type == 1){
            $result = DB::update("UPDATE tbl_epform SET status = :status WHERE tbl_epid = :id", ['status' => 0, 'id' => $id]);
            if($result)
                $status = "Success!";
            else
                $status = "Failed!";
            return redirect('inbox')->with('status', $status);
        }elseif($type == 2){
            $result = DB::update("UPDATE tbl_leave SET status = :status WHERE tbl_leaveid = :id", ['status' => 0, 'id' => $id]);
            if($result)
                $status = "Success!";
            else
                $status = "Failed!";
            return redirect('inbox')->with('status', $status);
        }elseif($type == 3){
            $result = DB::update("UPDATE tbl_chgschd SET status = :status WHERE chgschd_id = :id", ['status' => 0, 'id' => $id]);
            if($result)
                $status = "Success!";
            else
                $status = "Failed!";
            return redirect('inbox')->with('status', $status);
        }elseif($type == 4){
            $result = DB::update("UPDATE tbl_oas SET status =:status WHERE tbl_oasid = :id", ['status' => 0, 'id' => $id]);
            if($result)
                $status = "Success!";
            else
                $status = "Failed!";
            return redirect('inbox')->with('status', $status);
        }
    }

    protected function exitAdd(array $data)
    {
        $id = Auth::user()->id;
        $dateUpdate = date("Y-m-d H:i:s");
        return $db = DB::insert('INSERT INTO `tbl_epform`(`id`, `dateCreated`, `dateFrom`, `dateTo`, `textPurpose`, `dateUpdated`, `department_id`, `permission_id1`, `permission_id2`, `permission_id3`, `permission_id4`) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['dateFrom'], $data['dateTo'], $data['purpose'], $dateUpdate, $data['department'], $data['supervisor'], $data['projectManager'], $data['HR'], $data['companyRep']]);
    }
    /**
    *Display the Request for Leave of Absence Form Page
    *
    */
    public function requestForLeave(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $permissioners = DB::select("select * FROM users WHERE permissioners");
        $data = array(
                    'title' => 'Request for Leave of Absence',
                    'positions' => $positions,
                    'permissioners' => $permissioners,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('requestForLeave')->with($data);
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
        return redirect('inbox');
    }

    protected function requestAdd(array $data)
    {
        $id = Auth::user()->id;
        
        if($data['days_applied'] != 0){
            $days_taken = Auth::user()->days_taken + $data['days_applied'];
            Auth::user()->days_taken = $days_taken;
            Auth::user()->save();
            $db = DB::insert('INSERT INTO `tbl_leave`(`id`, `date_Created`, `reason`, `leave_type`, `days_applied`, `permission_id1`, `permission_id2`) values(?, ?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['reason'], $data['typeofLeave'], $data['days_applied'], $data['approvedBy'], $data['recommendApproval']]);
        }
    }


    /**
    *Display the Change Schedule Form Page
    *
    */
    public function changeSchedule(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $department = DB::select("SELECT department.* FROM `department` JOIN position ON position.position_id = :user_posid AND department.department_id = position.department_id", ['user_posid' => Auth::user()->position_id]);
        // $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $permissioners = DB::select("SELECT * FROM users WHERE permissioners");
        $HRs = DB::select("SELECT * FROM `users` JOIN position ON position.position_id = users.position_id AND position.department_id = 1");
        $Supervisors = DB::select("SELECT * FROM `users` WHERE `permissioners` = 1");
        $PMs = DB::select("SELECT * FROM `users` WHERE `permissioners` = 2");
        $CompanyReps = DB::select("SELECT * FROM `users` WHERE `permissioners` = 3");
        $data = array(
                    'title' => 'Change Schedule',
                    'positions' => $positions,
                    'HRs' => $HRs,
                    'department_user' => $department,
                    'Supervisors' => $Supervisors,
                    'PMs' => $PMs,
                    'CompanyReps' => $CompanyReps,
                    'permissioners' => $permissioners,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('changeSchedule')->with($data);
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
        $this->changeScheduleAdd($request->all());
        return redirect('inbox');
    }

    public function changeScheduleAdd(array $data){
        $dateUpdate = date("Y-m-d H:i:s");
        $id = Auth::user()->id;
        $db = DB::insert('INSERT INTO `tbl_chgschd`(`id`, `date_Created`, `department`, `date_from`, `date_to`, `shift_from`, `shift_to`, `reason`, `permission_id1`, `permission_id2`, `permission_id3`, `permission_id4`, `dateUpdated`, `form_type`) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['department'], $data['dateFromEffectivity'], $data['dateToEffectivity'], $data['dateFromShift'], $data['dateToShift'], $data['reason'], $data['supervisor'], $data['projectManager'], $data['permissioner'], $data['HR'], $dateUpdate, 3]);
    }

    /**
    *Display the Overtime Authorization Slip Form Page
    *
    */
    public function overtimeAuthSlip(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $department = DB::select("SELECT department.* FROM `department` JOIN position ON position.position_id = :user_posid AND department.department_id = position.department_id", ['user_posid' => Auth::user()->position_id]);
        $data = array(
                    'title' => 'Overtime Authorization Slip',
                    'positions' => $positions,
                    'department_user' => $department,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('overtimeAuthSlip')->with($data);
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
        return redirect('inbox');
    }

    protected function overtimeAuthSlipAdd(array $data)
    {
        $dateUpdate = date("Y-m-d H:i:s");
        $id = Auth::user()->id;
        $db = DB::insert('INSERT INTO `tbl_oas`(`id`, `date_Created`, `reason`, `client_id`, `dateUpdated`) values(?, ?, ?, ?, ?)', [$id, $data['dateCreated'], $data['reason'], $data['client'], $dateUpdate]);
    }

    public function getProfile(){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $positions = $this->position();
        $positions_all = $this->get_positions();
        $data = array(
                    'title' => 'Edit Profile',
                    'positions' => $positions,
                    'positions_all' => $positions_all,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('auth.editProfile')->with($data);
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
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        // $users = DB::table('users')->select('username', 'emp_name', 'emp_position', 'email')->groupBy('username')->get();
        $users = DB::select("select * FROM users LEFT JOIN position ON users.position_id=position.position_id");
        $positions = $this->position();
        $data = array(
                    'title' => 'Manage Accounts',
                    'users' => $users,
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('auth.accounts')->with($data);
    }

    /*Update the basic informations*/

    public function show($id){
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $user = User::find($id);
        $positions = $this->position();
        $positions_all = $this->get_positions();
        $data = array(
                    'title' => 'Edit User Profile',
                    'user' => $user,
                    'positions' => $positions,
                    'positions_all' => $positions_all,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('auth.editAccount')->with($data);
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
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $profileImage = $this->getImage();
        $user = User::find($id);
        $positions = $this->position();
        $data = array(
                    'title' => 'Reset Password',
                    'user' => $user,
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif
            );
        return view('auth.resetPassword')->with($data);
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
