<?php namespace Orbiagro\Models;

use Orbiagro\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Transformer;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\MechanicalInfo
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $motor
 * @property string $motor_serial
 * @property string $model
 * @property boolean $cylinders
 * @property integer $horsepower
 * @property integer $mileage
 * @property integer $traction
 * @property integer $lift
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-write mixed $horse_power
 * @property-read \Orbiagro\Models\Product $product
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereMotor($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereMotorSerial($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereModel($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereCylinders($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereHorsepower($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereMileage($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereTraction($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereLift($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\MechanicalInfo whereUpdatedBy($value)
 */
class MechanicalInfo extends Model
{

    use InternalDBManagement;

    protected $fillable = [
    'motor',
    'motor_serial',
    'model',
    'cylinders',
    'horsepower',
    'mileage',
    'traction',
    'lift',
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setLiftAttribute($value)
    {
        $this->attributes['lift'] = ModelValidation::byNonNegative($value);
    }

    public function setTractionAttribute($value)
    {
        $this->attributes['traction'] = ModelValidation::byNonNegative($value);
    }

    public function setMileageAttribute($value)
    {
        $this->attributes['mileage'] = ModelValidation::byNonNegative($value);
    }

    public function setCylindersAttribute($value)
    {
        $this->attributes['cylinders'] = ModelValidation::byNonNegative($value);
    }

    public function setHorsePowerAttribute($value)
    {
        $this->attributes['horsepower'] = ModelValidation::byNonNegative($value);
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // --------------------------------------------------------------------------
    // Metodos Publicos
    // --------------------------------------------------------------------------
    public function mileage_km()
    {
        $mileage = Transformer::toReadable($this->attributes['mileage']);

        if (isset($this->attributes['mileage'])) {
            return "{$mileage} Km.";
        }

        return null;
    }

    public function horsepower_hp()
    {
        $horsepower = Transformer::toReadable($this->attributes['horsepower']);

        if (isset($this->attributes['horsepower'])) {
            return "{$horsepower} HP.";
        }

        return null;
    }
}
