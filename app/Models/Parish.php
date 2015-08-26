<?php namespace Orbiagro\Models;

use Orbiagro\Models\Town;
use Orbiagro\Models\Direction;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Parish
 *
 * @property integer $id
 * @property integer $town_id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Orbiagro\Models\Town $town
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Direction[] $directions
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereTownId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Parish random()
 */
class Parish extends Model
{

    use InternalDBManagement, CanSearchRandomly;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    // --------------------------------------------------------------------------
    // Relaciones
    //
    // belongs to
    // --------------------------------------------------------------------------
    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    // --------------------------------------------------------------------------
    // has many
    // --------------------------------------------------------------------------
    public function directions()
    {
        return $this->hasMany(Direction::class);
    }
}
