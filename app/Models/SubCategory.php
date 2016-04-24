<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;
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
 * @property-read \Orbiagro\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Product[] $products
 * @property-read \Orbiagro\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Visit[] $visits
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
 * @mixin \Eloquent
 */
class SubCategory extends Model
{

    use InternalDBManagement, CanSearchRandomly, HasShortTitle;

    /**
     * @var array
     */
    protected $fillable = ['category_id', 'description', 'info'];

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value, 3);

        if ($this->attributes['description']) {
            $this->attributes['slug'] = str_slug($this->attributes['description']);
        }
    }

    /**
     * @param $value
     */
    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = ModelValidation::byLenght($value);
    }

    /**
     * @param $value
     * @return null|string
     */
    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value, 3) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getDescriptionAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    /**
     * @param $value
     * @return null|string
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\Illuminate\Database\Eloquent\Builder
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
