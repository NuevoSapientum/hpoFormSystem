<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateTimeChange extends Model
{
  protected $table = 'datetime_change';

  protected $fillable = [
      'dateFromEffectivity',
      'dateToEffectivity',
      'timeFromEffectivity',
      'timeToEffectivity',
      'dateFromShift',
      'dateToShift',
      'timeFromShift',
      'timeToShift',
      'user_id',
      'change_id',
      'created_at',
      'updated_at'
  ];

  public function users(){
    return $this->belongsTo('App\User', 'user_id');
  }

  public function change(){
    return $this->belongsTo('App\Change', 'change_id');
  }
}
