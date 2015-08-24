<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

class Feature extends Model
{

    use InternalDBManagement;

    protected $fillable = ['title', 'description'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ModelValidation::byLenght($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getTitleAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    public function product()
    {
        return $this->belongsTo('Orbiagro\Models\Product');
    }

    // --------------------------------------------------------------------------
    // Polimorfica
    // --------------------------------------------------------------------------
    public function file()
    {
        return $this->morphOne('Orbiagro\Models\File', 'fileable');
    }

    public function image()
    {
        return $this->morphOne('Orbiagro\Models\Image', 'imageable');
    }
}
