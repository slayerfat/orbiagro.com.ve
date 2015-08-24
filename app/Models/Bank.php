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
 * @property-read \Orbiagro\Models\User $user
 * @property-read \ $visitable
 */
class Bank extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    /**
     * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Billing[] $billings
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Billing[]
     */
    public function billings()
    {
        return $this->hasMany('Orbiagro\Models\Billing');
    }
}
