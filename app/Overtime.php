<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $table = "overtime_authorization";

    protected $fillable = [
   			'user_id',
   			'department_id',
   			'form_id',
   			'reason',
   			'purpose',
   			'client_id',
   			'status',
   			'created_at',
   			'updated_at'
    ];
}
