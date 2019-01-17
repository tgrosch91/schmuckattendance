<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'students';
  protected $fillable = ['student_id', 'language', 'grade'];

  /**
   * Get the user that owns the phone.
   */
  public function event()
  {
      return $this->hasMany('App\Event');
  }
  public function letters()
  {
      return $this->belongsToMany('App\Letter');
  }

}
