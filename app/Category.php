<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;
use App\Mamarrachismo\Traits\CanSearchRandomly;
use App\Mamarrachismo\Traits\HasShortTitle;

class Category extends Model
{

    use InternalDBManagement, CanSearchRandomly, HasShortTitle;

    protected $fillable = ['description', 'slug', 'info'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);

        if ($this->attributes['description']) {
            $this->attributes['slug'] = str_slug($this->attributes['description']);
        }
    }

    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
    }

    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = ModelValidation::byLenght($value);
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getDescriptionAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    public function getInfoAttribute($value)
    {
        if ($value) {
            if (substr($value, -1) !== '.') {
                $value .= '.';
            }

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
    public function subCategories()
    {
        return $this->hasMany('App\SubCategory');
    }

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function products()
    {
        return $this->hasManyThrough('App\product', 'App\SubCategory');
    }
}
