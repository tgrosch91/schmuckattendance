<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'events';
  protected $fillable = ['event_date', 'student_id', 'import_id', 'event_type_id', 'semester_id'];
  use SoftDeletes;
   protected $dates = ['deleted_at'];
  /**
 * Get the phone record associated with the user.
 */
  public function student()
  {
      return $this->belongsTo('App\Student');
  }
  public function semester()
  {
      return $this->belongsTo('App\Semester');
  }
  public function import()
  {
      return $this->belongsTo('App\Import');
  }
  public function event_type()
  {
      return $this->belongsTo('App\EventType');
  }
}
