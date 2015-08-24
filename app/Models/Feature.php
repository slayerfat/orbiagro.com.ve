<?php namespace Orbiagro\Models;

use Orbiagro\Models\File;
use Orbiagro\Models\Image;
use Orbiagro\Models\Product;
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
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Feature whereUpdatedAt($value)
 */
class Feature extends Model
{

    use InternalDBManagement;

    protected $fillable = ['title', 'description'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ModelValidation::byLenght($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getTitleAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // --------------------------------------------------------------------------
    // Polimorfica
    // --------------------------------------------------------------------------
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
