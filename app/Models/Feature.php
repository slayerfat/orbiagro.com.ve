<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Feature
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $title
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Orbiagro\Models\Product $product
 * @property-read \Orbiagro\Models\File $file
 * @property-read \Orbiagro\Models\Image $image
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feature extends Model
{

    use InternalDBManagement;

    /**
     * @var array
     */
    protected $fillable = ['title', 'description'];

    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ModelValidation::byLenght($value);
    }

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    /**
     * Devuelve el titulo en mayuscula
     *
     * @param $value
     * @return null|string
     */
    public function getTitleAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\Illuminate\Database\Eloquent\Builder
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\Illuminate\Database\Eloquent\Builder
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
