<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Category
 *
 * @property integer $id
 * @property string $description
 * @property string $info
 * @property string $slug
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\SubCategory[] $subCategories
 * @property-read \Orbiagro\Models\Image $image
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Category random()
 * @mixin \Eloquent
 */
class Category extends Model
{

    use InternalDBManagement, CanSearchRandomly, HasShortTitle;

    /**
     * @var array
     */
    protected $fillable = ['description', 'slug', 'info'];

    /**
     * @param $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);

        if ($this->attributes['description']) {
            $this->attributes['slug'] = str_slug($this->attributes['description']);
        }
    }

    /**
     * @param string $value
     * @return null|string
     */
    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
    }

    /**
     * @param $value
     * @return void
     */
    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = ModelValidation::byLenght($value);
    }

    /**
     * Regresa la descripcion con la primera letra en mayuscula
     *
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
     * Determina si existe o no un punto al final del texto y lo crea
     *
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\Illuminate\Database\Eloquent\Builder
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough|\Illuminate\Database\Eloquent\Builder
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            SubCategory::class
        );
    }
}
