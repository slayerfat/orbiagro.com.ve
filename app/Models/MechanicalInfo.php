<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Transformer;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

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
        return $this->belongsTo('Orbiagro\Models\Product');
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
