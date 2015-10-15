<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    private $redirectTo = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'position' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'vacation_leave' => 'required|max:30',
            'sick_leave' => 'required|max:30',
            'maternity_leave' => 'required|max:60',
            'paternity_leave' => 'required|max:30'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $image = "blank";
        $name = "blank";

        DB::insert("INSERT into `profile_image`(`picture_name`, `image`) values(?, ?)", [$name, $image]);
        $id = DB::select("SELECT id FROM profile_image");
        foreach ($id as $ids) {
            $id = $ids;
        }
        return User::create([
            'username' => $data['username'],
            'emp_name' => $data['name'],
            'position_id' => $data['position'],
            'permissioners' => 0,
            'img_id' => $id->id,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'VL_entitlement' => $data['vacation_leave'],
            'SL_entitlement' => $data['sick_leave'],
            'ML_entitlement' => $data['maternity_leave'],
            'PL_entitlement' => $data['paternity_leave']
        ]);
    }
}
