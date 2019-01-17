<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
      protected $table = 'semesters';
      /**
       * Get the user that owns the phone.
       */
      public function event()
      {
          return $this->hasMany('App\Event');
      }
}
