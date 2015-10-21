<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateTimeOvertime extends Model
{
    protected $table = 'datetime_overtime';

    protected $fillable = [
   			'dateFromOvertime',
   			'timeFromOvertime',
        'dateToOvertime',
        'timeToOvertime',
   			'user_id',
   			'overtime_id'
    ];

    public function users(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function overtime(){
    	return $this->belongsTo('App\Overtime', 'overtime_id');
    }
}
