<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Direction
 *
 * @property integer $id
 * @property integer $directionable_id
 * @property string $directionable_type
 * @property integer $parish_id
 * @property string $details
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $directionable
 * @property-read \Orbiagro\Models\MapDetail $map
 * @property-read \Orbiagro\Models\Parish $parish
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereDirectionableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereDirectionableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereParishId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereDetails($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Direction whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Direction extends Model
{

    use InternalDBManagement;

    /**
     * @var array
     */
    protected $fillable = ['parish_id', 'details'];

    /**
     * @param $value
     */
    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = ModelValidation::byLenght($value);
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getDetailsAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    /**
     * Relacion polimorfica
     *
     * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|\Illuminate\Database\Eloquent\Builder
     */
    public function directionable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function map()
    {
        return $this->hasOne(MapDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}
