<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;

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
        return $this->hasOne('App\MapDetail');
    }

    // --------------------------------------------------------------------------
    // belongs to
    // --------------------------------------------------------------------------
    public function parish()
    {
        return $this->belongsTo('App\Parish');
    }
}
