<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Storage;

/**
 * Orbiagro\Models\Image
 *
 * @property integer $id
 * @property integer $imageable_id
 * @property string $imageable_type
 * @property string $path
 * @property string $original
 * @property string $small
 * @property string $medium
 * @property string $large
 * @property string $mime
 * @property string $alt
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereImageableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereImageableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereOriginal($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereSmall($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereMedium($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereLarge($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereAlt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Image whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Image extends Model
{

    use InternalDBManagement;

    protected $fillable = [
        'path',
        'original',
        'small', 'medium',
        'large',
        'mime',
        'alt'
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setPathAttribute($value)
    {
        if ($this->fileExists($value)) {
            return $this->attributes['path'] = $value;
        }

        return $this->attributes['path'] = null;
    }

    public function setAltAttribute($value)
    {
        $this->attributes['alt'] = str_slug($value)
        .' en orbiagro.com.ve: subastas, compra y venta de productos y articulos en Venezuela.';
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getPathAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return null;
    }

    /**
     * Relacion polimorfica
     * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
     *
     * Category, SubCategory, Feature, Maker, Product, Promotion
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    // --------------------------------------------------------------------------
    // Private Methods
    // --------------------------------------------------------------------------
    private function fileExists($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return true;

        } elseif (Storage::disk('test')->exists($path)) {
            return true;
        }

        return false;
    }
}
