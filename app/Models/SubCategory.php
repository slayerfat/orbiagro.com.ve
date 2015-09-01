<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\SubCategory
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $description
 * @property string $info
 * @property string $slug
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|Visit[] $visits
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\SubCategory random()
 */
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
        return $this->belongsTo(Category::class);
    }

    // --------------------------------------------------------------------------
    // Has Many
    // --------------------------------------------------------------------------
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
