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
 * @property-read \ $directionable
 * @property-read MapDetail $map
 * @property-read Parish $parish
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
 */
class Direction extends Model
{

    use InternalDBManagement;

    protected $fillable = ['parish_id', 'details'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = ModelValidation::byLenght($value);
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getDetailsAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    /**
     * Relacion polimorfica
     * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
     */
    public function directionable()
    {
        return $this->morphTo();
    }

    // --------------------------------------------------------------------------
    // Has One
    // --------------------------------------------------------------------------
    public function map()
    {
        return $this->hasOne(MapDetail::class);
    }

    // --------------------------------------------------------------------------
    // belongs to
    // --------------------------------------------------------------------------
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}
