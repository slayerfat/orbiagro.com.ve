<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Gender
 *
 * @property integer $id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Person[] $people
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Gender whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Gender whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Gender whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Gender whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Gender whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Gender whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gender extends Model
{

    use InternalDBManagement;

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getDescriptionAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
