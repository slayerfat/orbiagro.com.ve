<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * TEST:
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $visitable_id
 * @property string $visitable_type
 * @property integer $total
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \ $visitable
 */
class Bank extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    /**
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Billing[] $billings
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Billing[]
     */
    public function billings()
    {
        return $this->hasMany('App\Billing');
    }
}
