<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{

	protected $table = 'positions';

    protected $fillable = [
    	'department_id',
    	'position_name'
    ];

    public function departments(){
        return $this->belongsTo('App\Departments', 'department_id');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
