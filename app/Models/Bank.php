<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Bank
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
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Billing[] $billings
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Bank whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Bank whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Bank whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Bank whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Bank whereUpdatedAt($value)
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
