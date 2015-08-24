<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

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
