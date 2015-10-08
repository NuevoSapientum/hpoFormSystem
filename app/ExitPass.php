<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitPass extends Model
{

	protected $table = "exit_pass";

    // protected $fillable = [
   	// 		'user_id',
   	// 		'department_id',
   	// 		'form_id',
   	// 		'reason',
   	// 		'purpose',
   	// 		'permission_id1',
   	// 		'permission_id2',
   	// 		'permission_id3',
   	// 		'permission_id4',
   	// 		'permission_1',
   	// 		'permission_2',
   	// 		'permission_3',
   	// 		'permission_4',
   	// 		'days_applied',
   	// 		'status',
   	// 		'created_at',
   	// 		'updated_at',
   	// 		'date_from',
   	// 		'date_to'
    // ];

    public function user(){
    	return $this->belongsToMany('App\User');
    }

    // public function departments(){
    // 	return $this->hasMany('App\Departments');
    // }
}
