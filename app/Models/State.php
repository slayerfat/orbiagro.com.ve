<?php namespace Orbiagro\Models;

use Orbiagro\Models\Town;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\State
 *
 * @property integer $id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Town[] $towns
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\State whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\State whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\State whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\State whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\State whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\State whereUpdatedAt($value)
 */
class State extends Model
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
    public function towns()
    {
        return $this->hasMany(Town::class);
    }
}
