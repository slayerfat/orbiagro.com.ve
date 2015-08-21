<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class PromoType extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // HasMany
    // --------------------------------------------------------------------------
    public function promotions()
    {
        return $this->hasMany('App\Promotion');
    }
}
