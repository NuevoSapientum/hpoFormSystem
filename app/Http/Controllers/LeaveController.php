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
use Illuminate\Support\Collection;

class LeaveController extends Controller
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

   public function vacationRecord(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $vacationRecords = Leaves::where('status', 1)
                                ->where('leave_type', 1)
                                ->get();
        $count = $this->forms();
        $collection = collect([]);

        foreach ($vacationRecords as $value) {
            $collection = collect([$value]);  
        }

        $data = array(
            'title' => 'Vacation Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'vacationRecords' => $collection,
            'count' => $count
        );

        return view('record.vacation')->with($data);
   }

   public function sickRecord(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $sickRecords = Leaves::where('status', 1)
                                ->where('leave_type', 2)
                                ->get();
        $collection = collect([]);
        $count = $this->forms();
        foreach ($sickRecords as $value) {
            $collection = collect([$value]);  
        }

        $data = array(
            'title' => 'Sick Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'sickRecords' => $collection,
            'count' => $count
        );

        return view('record.sick')->with($data);
   }

   public function maternalRecord(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $maternalRecords = Leaves::where('status', 1)
                                ->where('leave_type', 3)
                                ->get();

        $collection = collect([]);
        $count = $this->forms();
        foreach ($maternalRecords as $value) {
            $collection = collect([$value]);  
        }

        $data = array(
                'title' => 'Maternal Leave',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'maternalRecords' => $collection,
                'count' => $count
            );

        return view('record.maternal')->with($data);
   }

   public function paternalRecord(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $paternalRecords = Leaves::where('status', 1)
                                ->where('leave_type', 4)
                                ->get();
        $collection = collect([]);
        $count = $this->forms();
        foreach ($paternalRecords as $value) {
            $collection = collect([$value]);  
        }

        $data = array(
            'title' => 'Paternal Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'paternalRecords' => $collection,
            'count' => $count
        );

        return view('record.paternal')->with($data);
   }

   public function view($type, $id){
        if($type == 1){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $empDepartment = Positions::find($id_user)->departments;
            $count = $this->forms();
            $contents = Leaves::where('leave_type', $type)
                                     ->where('id', $id)
                                     ->get();
            $data = array(
                'title' => 'Vacation Leave',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'contents' => $contents,
                'permissioners' => $permissioners,
                'count' => $count
            );
            // echo $id;
            // dd($vacationRecords);
            return view('record.vacationView')->with($data);
        }elseif($type == 2){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $count = $this->forms();
            $contents = Leaves::where('leave_type', 2)
                                    ->where('id', $id)
                                    ->get();
            $data = array(
                'title' => 'Sick Leave',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'permissioners' => $permissioners,
                'contents' => $contents,
                'count' => $count
            );

            return view('record.sickView')->with($data);
        }elseif($type == 3){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $count = $this->forms();
            $contents = Leaves::where('leave_type', 3)
                                    ->where('id', $id)
                                    ->get();
            $data = array(
                'title' => 'Maternal Leave',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'permissioners' => $permissioners,
                'contents' => $contents,
                'count' => $count
            );

            return view('record.maternalView')->with($data);
        }elseif($type == 4){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $permissioners = User::where('permissioners', '!=', 0)->get();
            $count = $this->forms();
            $contents = Leaves::where('leave_type', 4)
                                    ->where('id', $id)
                                    ->get();
            $data = array(
                'title' => 'Paternal Leave',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'permissioners' => $permissioners,
                'contents' => $contents,
                'count' => $count
            );

            return view('record.paternalView')->with($data);
        }
   }

}
