<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConfirmation extends Model {

  /**
   * La tabla no posee timestamps
   *
   * @var boolean
   */
  public $timestamps = false;

  protected $fillable = [
    'data'
  ];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setDataAttribute($valor)
  {
    $this->attributes['data'] = str_random(32);
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs to
  // --------------------------------------------------------------------------
  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
