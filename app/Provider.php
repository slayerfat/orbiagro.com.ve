<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;
use App\Mamarrachismo\Traits\CanSearchRandomly;

class Provider extends Model {

  use InternalDBManagement, CanSearchRandomly;

  protected $fillable = [
    'name',
    'slug',
    'url',
    'contact_name',
    'contact_title',
    'contact_email',
    'contact_phone_1',
    'contact_phone_2',
    'contact_phone_3',
    'contact_phone_4',
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
