<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use App\Positions;

class AdminAuthentication
{
    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $HR = Departments::where('id', 8);
        // if($this->auth->check()){
        //     if($this->auth->user()->position_id == 1){
        //         return $next($request);
        //     }
        // }
        $id = $this->auth->user()->position_id;
        $empDepartment = Positions::find($id)->departments;
        if($this->auth->check()){
            
            if($empDepartment->department_name == "Human Resource"){
                return $next($request);
            }
        }
        // echo "1";
        return new RedirectResponse(url('/'));
    }
}
