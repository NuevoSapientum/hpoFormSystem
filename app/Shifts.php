<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
   	protected $table = 'shifts';

    protected $fillable = [
    	'shift_from',
    	'shift_to'
    ];
}
