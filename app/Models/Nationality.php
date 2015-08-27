<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Nationality
 *
 * @property integer $id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Person[] $people
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nationality whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nationality whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nationality whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nationality whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nationality whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nationality whereUpdatedAt($value)
 */
class Nationality extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getDescriptionAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
