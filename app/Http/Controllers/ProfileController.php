<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Validator;
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


class ProfileController extends Controller
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
        return count($exitPass) + count($leaveForm) + count($changeSchedule);
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

    public function updateImage($name, $image){
       return DB::update("UPDATE `profile_image` SET `picture_name` = :name, `image` = :image WHERE `id` = :user_picture", ['name' => $name, 'image' => $image, 'user_picture' => Auth::user()->img_id]);
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
        $positions = $this->position();
        $positions_all = Positions::all();
        $user_position = Auth::user()->position_id;
        $empDepartment = Positions::find($user_position)->departments;
        $data = array(
                    'title' => 'Edit Profile',
                    'positions' => $positions,
                    'positions_all' => $positions_all,
                    'profileImage' => $profileImage,
                    'inboxNotif' => $inboxNotif,
                    'approvalNotif' => $approvalNotif,
                    'empDepartment' => $empDepartment
            );
        return view('auth.editProfile')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(array $data)
    {
        Auth::user()->emp_name = $data['name'];
        Auth::user()->position_id = $data['position'];
        Auth::user()->email = $data['email'];
        return Auth::user()->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
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

        if(implode($file)){
            if(getimagesize($_FILES['image']['tmp_name']) == FALSE){
                echo "Please select an image.";
            }else{
                $image = addslashes($_FILES['image']['tmp_name']);
                $name = addslashes($_FILES['image']['tmp_name']);
                $image = file_get_contents($image);
                $image = base64_encode($image);
                $this->updateImage($name, $image);
                $result = $this->store($request->all());
                echo "1";
                if($result){
                    echo "2";
                    $status = "Success!";
                }else{
                    echo "3";
                    $status = "Failed!";
                }
            }
        }else{
            echo "4";
            $result = $this->store($request->all());
            if($result){
                echo "5";
                $status = "Success!";
            }else{
                echo "6";
                $status = "Failed!";
            }
        }

        echo $status;
        return redirect('/dashboard')->with('status', $status);
        
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
}
