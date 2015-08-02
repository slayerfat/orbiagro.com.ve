<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Town extends Model {

  use InternalDBManagement;

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['created_at', 'updated_at'];

  /**
   * Relaciones
   */
  public function state()
  {
    return $this->belongsTo('App\State');
  }

  public function parishes()
  {
    return $this->hasMany('App\Parish');
  }
}
