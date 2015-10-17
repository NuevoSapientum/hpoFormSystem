<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $fillable = [
   			'user_id',
   			'department_id',
   			'form_id',
   			'reason',
   			'purpose',
   			'permission_id1',
   			'permission_id2',
   			'permission_1',
   			'permission_2',
   			'days_applied',
        'start_date',
   			'status',
   			'leave_type',
   			'created_at',
   			'updated_at'
    ];

    public function users(){
      return $this->belongsTo('App\User', 'user_id');
    }

}
