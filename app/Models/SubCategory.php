<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;

class SubCategory extends Model
{

    use InternalDBManagement, CanSearchRandomly, HasShortTitle;

    protected $fillable = ['category_id', 'description', 'info'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value, 3);

        if ($this->attributes['description']) {
            $this->attributes['slug'] = str_slug($this->attributes['description']);
        }
    }

    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = ModelValidation::byLenght($value);
    }

    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value, 3) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
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
    // Scopes
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function category()
    {
        return $this->belongsTo('Orbiagro\Models\Category');
    }

    // --------------------------------------------------------------------------
    // Has Many
    // --------------------------------------------------------------------------
    public function products()
    {
        return $this->hasMany('Orbiagro\Models\Product');
    }

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function image()
    {
        return $this->morphOne('Orbiagro\Models\Image', 'imageable');
    }

    public function visits()
    {
        return $this->morphMany('Orbiagro\Models\Visit', 'visitable');
    }
}
