<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;

/**
 * Orbiagro\Models\Maker
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $domain
 * @property string $url
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereDomain($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Maker random()
 */
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
        return $this->hasMany(Product::class);
    }

    // --------------------------------------------------------------------------
    // Belongs to Many
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
