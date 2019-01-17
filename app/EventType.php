<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
  protected $table = 'event_types';

  /**
   * Get the user that owns the phone.
   */
  public function event()
  {
      return $this->hasMany('App\Event');
  }
}
