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

    /**
     * @var array
     */
    protected $fillable = [
        'path',
        'original',
        'small',
        'medium',
        'large',
        'mime',
        'alt',
    ];

    /**
     * Determina si el archivo existe realmente antes de aceptarlo como dato.
     *
     * @param $value
     * @return null
     */
    public function setPathAttribute($value)
    {
        if ($this->fileExists($value)) {
            return $this->attributes['path'] = $value;
        }

        return $this->attributes['path'] = null;
    }

    /**
     * Determina si el archivo existe o no tanto en modo prueba como normal.
     *
     * @param $path
     * @return bool
     */
    private function fileExists($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return true;
        } elseif (Storage::disk('test')->exists($path)) {
            return true;
        } elseif (file_exists($path)) {
            return true;
        }

        return false;
    }

    /**
     * Genera un alt valido para esta imagen.
     *
     * @param $value
     */
    public function setAltAttribute($value)
    {
        $this->attributes['alt'] = str_slug($value)
            . ' en orbiagro.com.ve: subastas, compra y venta de productos y articulos en Venezuela.';
    }

    /**
     * @param $value
     * @return null
     */
    public function getPathAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return null;
    }

    /**
     * Category, SubCategory, Feature, Maker, Product, Promotion
     *
     * @link http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|\Illuminate\Database\Eloquent\Builder
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
