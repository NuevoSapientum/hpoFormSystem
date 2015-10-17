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

class PagesController extends Controller
{

    public function login(){
        return view('auth.login');
    }

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

    // public function notification(){
    //     $id = Auth::user()->id;
    //     $exitPass = ExitPass::where('status', '!=', 3)
    //                         ->where(function($query){
    //                             $id = Auth::user()->id;
    //                             $query->where('permission_id1', $id)
    //                             ->orWhere('permission_id2', $id)
    //                             ->orWhere('permission_id3', $id)
    //                             ->orWhere('permission_id4', $id);
    //                         })
    //                         ->get();
    //    $leaveForm = Leaves::where('status', '!=', 3)
    //                         ->where(function($query){
    //                             $id = Auth::user()->id;
    //                             $query->where('permission_id1', $id)
    //                             ->orWhere('permission_id2', $id);
    //                         })
    //                         ->get();
    //    $changeSchedule = Change::where('status', '!=', 3)
    //                         ->where(function($query){
    //                             $id = Auth::user()->id;
    //                             $query->where('permission_id1', $id)
    //                             ->orWhere('permission_id2', $id)
    //                             ->orWhere('permission_id3', $id)
    //                             ->orWhere('permission_id4', $id);
    //                         })
    //                         ->get();
    //     $overtime = Overtime::where('status', '!=', 3)
    //                         ->where('permission_id1', $id)
    //                         ->get();
        
    //     $needApproval = 0;

    //     foreach ($exitPass as $exit) {
    //         if($exit->permission_id1 == $id){
    //             echo "1";
    //         }elseif($exit->permission_id2 == $id){
    //             echo "2";
    //         }elseif($exit->permission_id3 == $id){
    //             echo "3";
    //         }elseif($exit->permission_id4 == $id){
    //             echo "4";
    //         }
    //     }

    //     foreach ($leaveForm as $exit) {
    //         if($exit->permission_id1 == $id){
    //             echo "1";
    //         }elseif($exit->permission_id2 == $id){
    //             echo "2";
    //         }
    //     }

    //     foreach ($changeSchedule as $exit) {
    //         if($exit->permission_id1 == $id){
    //             echo "1";
    //         }elseif($exit->permission_id2 == $id){
    //             echo "2";
    //         }elseif($exit->permission_id3 == $id){
    //             echo "3";
    //         }elseif($exit->permission_id4 == $id){
    //             echo "4";
    //         }
    //     }

    //     foreach ($overtime as $over) {
    //         if($over->permission_id1 == $id){
    //             if($over->permission_1 == 0){
    //                 $needApproval++;
    //             }
    //         }
    //     }
    //     return $needApproval;
    //     // $notification = $approvalNotif;

    //     // return $notification;
    // }

    protected function position(){
        $positions = Positions::where('id', Auth::user()->position_id)->get();
        return $positions; 
    }

    protected function getImage(){
        $con=mysqli_connect("localhost","root","password","hpodb");
        $qry = "select * from profile_image where id = '".Auth::user()->img_id."'";
        
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
        $exitPass = ExitPass::all();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        // $notification = $this->notification();
        $data = array(
                    'title' => 'Home',
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment
            );
        // echo $this->notification();
        return view('dashboard')->with($data);
    }


    /**
    *Display the History Page
    *
    */
    public function history(){
        $id = Auth::user()->id;
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $exitPass = ExitPass::where('user_id', Auth::user()->id)->get();
        $leaveForm = Leaves::where('user_id', Auth::user()->id)->get();
        $changeSchedule = Change::where('user_id', Auth::user()->id)->get();
        $oas = Overtime::where('user_id', Auth::user()->id)->get();
        $data = array(
                    'title' => 'History',
                    'positions' => $positions,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'exitPass' => $exitPass,
                    'leaveForm' => $leaveForm,
                    'changeSchedule' => $changeSchedule,
                    'oas' => $oas,
                    'empDepartment' => $empDepartment
            );

        return view('history')->with($data);
    }

    public function exitApprovals($id){
        return ExitPass::where('status', '!=', 3)
                    ->get();
        // return ExitPass::all();
    }

    public function submittedForms(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $exitPass = ExitPass::where('status', '!=', 3)->get();
        $leaveForm = Leaves::where('status', '!=', 3)->get();
        $changeSchedule = Change::where('status', '!=', 3)->get();
        $oas = Overtime::where('status', '!=', 3)->get();
        $data = array(
            'title' => 'Submitted Forms',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'exitPass' => $exitPass,
            'leaveForm' => $leaveForm,
            'changeSchedule' => $changeSchedule,
            'oas' => $oas
        );

        // echo $exitPass->users->emp_name;
        // $exit = $this->exitApprovals(Auth::user()->id);
        // dd($exit);
        // foreach ($exitPass as $exit) {
        //     echo $exit->users->emp_name;
        // }

        return view('submittedForms')->with($data);
    }

}
