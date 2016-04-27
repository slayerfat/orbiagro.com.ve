<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Product[] $products
 * @property-read \Orbiagro\Models\Image $image
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
 * @mixin \Eloquent
 */
class Maker extends Model
{

    use InternalDBManagement, CanSearchRandomly;

    /**
     * @var array
     */
    protected $fillable = ['name', 'domain', 'url'];


    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ModelValidation::byLenght($value, 3);
        $this->attributes['slug'] = str_slug($this->attributes['name']);
    }

    /**
     * @param $value
     * @return null|string
     */
    public function setSlugAttribute($value)
    {
        $slug = ModelValidation::byLenght($value, 3);

        if ($slug !== null) {
            return $this->attributes['slug'] = str_slug($slug);
        }

        return $this->attributes['slug'] = null;
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
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
}
