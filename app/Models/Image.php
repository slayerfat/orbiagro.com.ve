<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;

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
