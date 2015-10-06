<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{

	protected $table = 'position';

	public $timestamps = false;

    protected $fillable = [
    	'department_id',
    	'position_name',
    	'status'
    ];

    public function user(){
    	return $this->hasMany('hpoforms/User');
    }


}
