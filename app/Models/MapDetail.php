<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\MapDetail
 *
 * @property integer $id
 * @property integer $direction_id
 * @property float $latitude
 * @property float $longitude
 * @property boolean $zoom
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Orbiagro\Models\Direction $direction
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereDirectionId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereZoom($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MapDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MapDetail extends Model
{

    use InternalDBManagement;

    protected $fillable = ['latitude', 'longitude', 'zoom'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setLatitudeAttribute($value)
    {
        $this->attributes['latitude'] = ModelValidation::byNumeric($value);

        if (abs($this->attributes['latitude']) >= 91) {
            $this->attributes['latitude'] = null;
        }
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = ModelValidation::byNumeric($value);

        if (abs($this->attributes['longitude']) >= 181) {
            $this->attributes['longitude'] = null;
        }
    }

    public function setZoomAttribute($value)
    {
        $this->attributes['zoom'] = ModelValidation::byNonNegative($value);

        if (abs($this->attributes['zoom']) > 24) {
            $this->attributes['zoom'] = null;
        }
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    // --------------------------------------------------------------------------
    // belongs to
    // --------------------------------------------------------------------------
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
}
