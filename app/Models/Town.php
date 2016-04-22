<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Town
 *
 * @property integer $id
 * @property integer $state_id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Orbiagro\Models\State $state
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Parish[] $parishes
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Town whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Town extends Model
{

    use InternalDBManagement;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function parishes()
    {
        return $this->hasMany(Parish::class);
    }
}
