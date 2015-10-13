<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{

	// protected $table = 'positions';

	// public $timestamps = false;

    // protected $fillable = [
    // 	'department_id',
    // 	'position_name'
    // ];

    // public function user(){
    // 	return $this->hasMany('hpoforms/User');
    // }

    public function departments(){
        return $this->belongsTo('App\Departments');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
