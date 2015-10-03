<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;


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
        $positions = DB::select("select * FROM position");
        return view('auth.register')->with('positions_all', $positions);
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

        $this->create($request->all());
        $image = "blank";
        $name = "blank";
        $users = DB::select("SELECT id FROM users ORDER BY id DESC LIMIT 1");
        $id;
        foreach ($users as $user) {
            $id = $user->id;
        }
        DB::insert("INSERT into `profile_image`(`name`, `image`, `id`) values(?, ?, ?)", [$name, $image, $id]);
        return redirect($this->redirectPath());
    }
}
