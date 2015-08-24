<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\ModelValidation;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;

class Provider extends Model
{

    use InternalDBManagement, CanSearchRandomly;

    protected $fillable = [
        'name',
        'slug',
        'url',
        'contact_name',
        'contact_title',
        'contact_email',
        'contact_phone_1',
        'contact_phone_2',
        'contact_phone_3',
        'contact_phone_4',
        'email',
        'phone_1',
        'phone_2',
        'phone_3',
        'phone_4',
        'trust'
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ModelValidation::byLenght($value);

        if ($this->attributes['name'] !== null) {
            $this->attributes['slug'] = str_slug($this->attributes['name']);
        }
    }

    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value) !== null) {
            return $this->attributes['slug'] = str_slug($value);
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
    // Scopes
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------
    public function products()
    {
        return $this->belongsToMany('Orbiagro\Models\Product')->withPivot('sku');
    }
}
