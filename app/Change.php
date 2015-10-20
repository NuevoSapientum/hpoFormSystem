<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    protected $table = "change_schedules";

    protected $fillable = [
   			'user_id',
   			'department_id',
   			'form_id',
   			'reason',
   			'purpose',
   			'permission_id1',
   			'permission_id2',
   			'permission_id3',
   			'permission_id4',
   			'permission_1',
   			'permission_2',
   			'permission_3',
   			'permission_4',
   			'status',
   			'created_at',
   			'updated_at',
        'shift_id',
   			'dateFromShift',
   			'dateToShift'
    ];

    public function users(){
      return $this->belongsTo('App\User', 'user_id');
    }

}
