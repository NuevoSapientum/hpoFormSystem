<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Positions;
use App\Shifts;
use App\User;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $positions = Positions::all();
        $shifts = Shifts::all();
        $data = array(
                    'positions_all' => $positions,
                    'shifts' => $shifts
                );
        return view('auth.register')->with($data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $flag = 0;

        $users = User::all();
        foreach ($users as $user) {
            if($user->username == $request->input('username')){
                    $flag = 1;
            }
        }

        if($flag == 1){
            $status = "Username is already taken!";
        }else{
            if($this->create($request->all())){
                $status = "Success!";
            }else{
                $status = "Failed!";
            }
        }  
        
        return redirect('dashboard')->with('status', $status);
    }
}
