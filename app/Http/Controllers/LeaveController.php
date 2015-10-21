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
        $users = User::all();
        $count = $this->forms();
        $balance = array();
        $collection = collect([]);
        foreach ($users as $user) {
            $vacationRecord = Leaves::where('leave_type', 1)
                                ->where('user_id', $user->id)
                                ->first();
            // if($vacationRecord->status() = 1){
            //     $collection = collect([$vacationRecord]);
            // }
            foreach ($vacationRecord as $vac) {
                echo $vac->status;
            }
            array_push($balance, $user->VL_entitlement - $user->VL_taken);
        }

        $i = 0;

        $data = array(
            'title' => 'Vacation Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'vacationRecords' => $collection,
            'users' => $users,
            'i' => $i,
            'balance' => $balance,
            'count' => $count
        );

        // dd($balance);
        // dd($collection);
        // return view('record.vacation')->with($data);
   }

   public function sickRecord(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $users = User::all();
        $count = $this->forms();
        $balance = array();
        $collection = collect([]);
        foreach ($users as $user) {
            $sickRecord = Leaves::where('leave_type', 2)
                                ->where('user_id', $user->id)
                                ->first();
            if($sickRecord){
                $collection = collect([$sickRecord]);
            }
            array_push($balance, $user->SL_entitlement - $user->SL_taken);
        }

        $i = 0;

        $data = array(
            'title' => 'Sick Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'balance' => $balance,
            'i' => $i,
            'users' => $users,
            'sickRecords' => $collection,
            'count' => $count
        );

        dd($collection);

        // return view('record.sick')->with($data);
   }

   public function maternalRecord(){
        $positions = $this->position();
        $profileImage = $this->getImage();
        $inboxNotif = $this->inboxNotif();
        $approvalNotif = $this->approvalNotif();
        $id = Auth::user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        $users = User::all();
        $count = $this->forms();
        $balance = array();
        $collection = collect([]);
        foreach ($users as $user) {
            $maternalRecord = Leaves::where('leave_type', 3)
                                ->where('user_id', $user->id)
                                ->first();
            if($maternalRecord){
                $collection = collect([$maternalRecord]);
            }
            array_push($balance, $user->ML_entitlement - $user->ML_taken);
        }

        $i = 0;

        $data = array(
            'title' => 'Maternal Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'balance' => $balance,
            'i' => $i,
            'users' => $users,
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
        $users = User::all();
        $count = $this->forms();
        $balance = array();
        $collection = collect([]);
        foreach ($users as $user) {
            $paternalRecord = Leaves::where('leave_type', 4)
                                ->where('user_id', $user->id)
                                ->first();
            if($paternalRecord){
                $collection = collect([$paternalRecord]);
            }
            array_push($balance, $user->PL_entitlement - $user->PL_taken);
        }

        $i = 0;

        $data = array(
            'title' => 'Paternal Leave',
            'positions' => $positions,
            'profileImage' => $profileImage,
            'inboxNotif' => $inboxNotif,
            'approvalNotif' => $approvalNotif,
            'empDepartment' => $empDepartment,
            'balance' => $balance,
            'i' => $i,
            'users' => $users,
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
            $contents = Leaves::where('leave_type', $type)
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
            $contents = Leaves::where('leave_type', $type)
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
            $contents = Leaves::where('leave_type', $type)
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

   public function viewUserVacations($id){
        $users = User::find($id);
        // dd($user)
        $vacationUser = Leaves::where('leave_type', 1)
                              ->where('user_id', $id)->first();

        if($vacationUser){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $vacationRecords = Leaves::where('leave_type', 1)
                                     ->where('user_id', $id)
                                     ->get();
            $count = $this->forms();
            $balance = 0;
            foreach ($vacationRecords as $vacation) {
                $balance = $vacation->users->VL_entitlement - $vacation->users->VL_taken;
                $VL_entitlement = $vacation->users->VL_entitlement;
            }

            $data = array(
                'title' => 'View User Vacation Leaves',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'count' => $count,
                'vacationRecords' => $vacationRecords,
                'balance' => max($balance,0),
                'VL_entitlement' => $VL_entitlement,
                'users' => $users
            );


            return view('record.userVacations')->with($data);
        }else{
            return redirect('dashboard')->with('status', 'Error: No Vacation Records Found');
        }
   }

   public function viewUserSick($id){
        $users = User::find($id);
        // dd($user)
        $sickUser = Leaves::where('leave_type', 2)
                          ->where('user_id', $id)->first();
        if($sickUser){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $sickRecords = Leaves::where('leave_type', 2)
                                     ->where('user_id', $id)
                                     ->get();
            $count = $this->forms();
            $balance = 0;
            foreach ($sickRecords as $sick) {
                $balance = $sick->users->SL_entitlement - $sick->users->SL_taken;
                $SL_entitlement = $sick->users->SL_entitlement;
            }

            $data = array(
                'title' => 'View User Sick Leaves',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'count' => $count,
                'sickRecords' => $sickRecords,
                'balance' => max($balance,0),
                'SL_entitlement' => $SL_entitlement,
                'users' => $users
            );

            return view('record.userSick')->with($data);
        }else{
            return redirect('dashboard')->with('status', 'Error: No Sick Records Found');
        }
        
   }

   public function viewUserMaternal($id){
        $users = User::find($id);
        // dd($user)
        $maternalUser = Leaves::where('leave_type', 3)
                               ->where('user_id', $id)->first();
        if($maternalUser){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $maternalRecords = Leaves::where('leave_type', 3)
                                     ->where('user_id', $id)
                                     ->get();
            $count = $this->forms();
            $balance = 0;
            foreach ($maternalRecords as $maternal) {
                $balance = $maternal->users->ML_entitlement - $maternal->users->ML_taken;
                $ML_entitlement = $maternal->users->ML_entitlement;
            }

            $data = array(
                'title' => 'View User Maternal Leaves',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'count' => $count,
                'maternalRecords' => $maternalRecords,
                'balance' => max($balance,0),
                'ML_entitlement' => $ML_entitlement,
                'users' => $users
            );


            return view('record.userMaternal')->with($data);
        }else{
            return redirect('dashboard')->with('status', 'Error: No Maternal Records Found');
        }
   }

   public function viewUserPaternal($id){
        $users = User::find($id);
        // dd($user)
        $paternalUser = Leaves::where('leave_type', 4)
                               ->where('user_id', $id)->first();
        if($paternalUser){
            $positions = $this->position();
            $profileImage = $this->getImage();
            $inboxNotif = $this->inboxNotif();
            $approvalNotif = $this->approvalNotif();
            $id_user = Auth::user()->position_id;
            $empDepartment = Positions::find($id_user)->departments;
            $paternalRecords = Leaves::where('leave_type', 4)
                                     ->where('user_id', $id)
                                     ->get();
            $count = $this->forms();
            $balance = 0;
            foreach ($paternalRecords as $paternal) {
                $balance = $paternal->users->PL_entitlement - $paternal->users->PL_taken;
                $PL_entitlement = $paternal->users->PL_entitlement;
            }

            $data = array(
                'title' => 'View User Paternal Leaves',
                'positions' => $positions,
                'profileImage' => $profileImage,
                'inboxNotif' => $inboxNotif,
                'approvalNotif' => $approvalNotif,
                'empDepartment' => $empDepartment,
                'count' => $count,
                'paternalRecords' => $paternalRecords,
                'balance' => max($balance, 0),
                'PL_entitlement' => $PL_entitlement,
                'users' => $users
            );


            return view('record.userPaternal')->with($data);
        }else{
            return redirect('dashboard')->with('status', 'Error: No Paternal Records Found');
        }
   }

}
