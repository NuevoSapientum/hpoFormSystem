<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
	protected $fillable = [
		'department_name',
		'created_at',
		'updated_at'
	];

	protected $hidden = [
		'id'
	];
    public function positions(){
    	return $this->hasMany('App\Positions');
    }
}
