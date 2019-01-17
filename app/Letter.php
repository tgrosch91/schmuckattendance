<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
  protected $table = 'letters';
  public function roles()
  {
    return $this->belongsToMany('App\Student');
  }
}
