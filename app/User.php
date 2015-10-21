<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['emp_name', 
                            'position_id', 
                            'email', 
                            'username', 
                            'password', 
                            'entitlement', 
                            'permissioners', 
                            'img_id', 
                            'days_taken',
                            'VL_entitlement',
                            'SL_entitlement',
                            'ML_entitlement',
                            'PL_entitlement',
                            'emp_gender',
                            'shift_id'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function exitPass(){
        return $this->hasMany('App\ExitPass');
    }

    public function leaves(){
        return $this->hasMany('App\Leaves');
    }

    public function change(){
        return $this->hasMany('App\Change');
    }

    public function shifts(){
        return $this->hasOne('App\Shifts');
    }
}
