<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Nutritional extends Model
{

    use InternalDBManagement;

    protected $fillable = ['due'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDueAttribute($value)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if ($date) {
            return $this->attributes['due'] = $value;
        }

        return $this->attributes['due'] = null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
