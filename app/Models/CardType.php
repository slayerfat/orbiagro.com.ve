<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

class CardType extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    public function billings()
    {
        return $this->hasMany('App\Billing');
    }
}
