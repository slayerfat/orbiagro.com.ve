<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;

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
        return $this->hasMany('Orbiagro\Models\SubCategory');
    }

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function image()
    {
        return $this->morphOne('Orbiagro\Models\Image', 'imageable');
    }

    public function products()
    {
        return $this->hasManyThrough('Orbiagro\Models\Product', 'Orbiagro\Models\SubCategory');
    }
}
