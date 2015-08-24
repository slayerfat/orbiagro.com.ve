<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;

class Maker extends Model
{

    use InternalDBManagement, CanSearchRandomly;

    protected $fillable = ['name', 'domain', 'url'];


    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ModelValidation::byLenght($value, 3);
        $this->attributes['slug']  = str_slug($this->attributes['name']);
    }

    public function setSlugAttribute($value)
    {
        $slug = ModelValidation::byLenght($value, 3);

        if ($slug !== null) {
            return $this->attributes['slug'] = str_slug($slug);
        }

        return $this->attributes['slug'] = null;
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    // --------------------------------------------------------------------------
    // Has Many
    // --------------------------------------------------------------------------
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    // --------------------------------------------------------------------------
    // Belongs to Many
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}
