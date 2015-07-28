<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {

  protected $fillable = [
    'name',
    'slug',
    'url',
    'contact_name',
    'contact_title',
    'email',
    'phone_1',
    'phone_2',
    'phone_3',
    'phone_4',
    'trust'
  ];

  // --------------------------------------------------------------------------
  // Scopes
  // --------------------------------------------------------------------------
  public function scopeRandom($query)
  {
    if (env('APP_ENV') == 'testing')
    {
      $query->orderByRaw('RANDOM()');
    }
    else
    {
      $query->orderByRaw('RAND()');
    }
  }


  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs To Many
  // --------------------------------------------------------------------------
  public function products()
  {
   return $this->belongsToMany('App\Product')->withPivot('sku');
  }

}
