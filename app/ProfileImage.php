<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    protected $table = "profile_image";

    public function user(){
    	return $this->hasOne('App\User');
    }
}
