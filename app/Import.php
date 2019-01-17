<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Import extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
   use SoftDeletes, SoftCascadeTrait;
  protected $table = 'imports';
   protected $dates = ['deleted_at'];
   protected $softCascade = ['events'];
   public function events()
   {
       return $this->hasMany('App\Event');
   }
}
