<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Transformer;

/**
 * Orbiagro\Models\Promotion
 *
 * @property integer $id
 * @property integer $promo_type_id
 * @property string $title
 * @property string $slug
 * @property integer $percentage
 * @property integer $static
 * @property string $begins
 * @property string $ends
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Product[] $products
 * @property-read \Orbiagro\Models\PromoType $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Image[] $images
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion wherePromoTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion wherePercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereStatic($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereBegins($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereEnds($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Promotion random()
 * @mixin \Eloquent
 */
class Promotion extends Model
{

    use InternalDBManagement, CanSearchRandomly, HasShortTitle;

    protected $fillable = [
        'title',
        'slug',
        'percentage',
        'static',
        'begins',
        'ends',
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ModelValidation::byLenght($value);

        if ($this->attributes['title']) {
            $this->attributes['slug'] = str_slug($this->attributes['title']);
        }
    }

    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
    }

    public function setBeginsAttribute($value)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if ($date) {
            return $this->attributes['begins'] = $value;
        }

        return $this->attributes['begins'] = null;
    }

    public function setEndsAttribute($value)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if ($date) {
            return $this->attributes['ends'] = $value;
        }

        return $this->attributes['ends'] = null;
    }

    public function setStaticAttribute($value)
    {
        if ($value > 0 && is_numeric($value)) {
            return $this->attributes['static'] = $value;
        }

        return $this->attributes['static'] = null;
    }

    public function setPercentageAttribute($value)
    {
        if ($value > 0 && is_numeric($value)) {
            if ($this->isFloat($value)) {
                return $this->attributes['percentage'] = $value * 100;
            }

            return $this->attributes['percentage'] = $value;
        }

        return $this->attributes['percentage'] = null;
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
    // Scopes
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs to Many
    // --------------------------------------------------------------------------
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function type()
    {
        return $this->belongsTo(PromoType::class, 'promo_type_id', 'id');
    }

    // --------------------------------------------------------------------------
    // Polimorfica
    // --------------------------------------------------------------------------
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // --------------------------------------------------------------------------
    // Funciones publicas
    // --------------------------------------------------------------------------

    /**
     * Devuelve el descuento estatico concadenado con Bs.
     */
    public function readableStatic($otherNumber = null)
    {
        if ($otherNumber) {
            return Transformer::toReadable($otherNumber);
        }

        if (!isset($this->attributes['static'])) {
            return null;
        }

        $price = Transformer::toReadable($this->attributes['static']);

        return "Bs. {$price}";
    }

    /**
     * Devuelve el descuento en porcentaje concadenado con %.
     */
    public function readablePercentage()
    {
        if (isset($this->attributes['percentage'])) {
            return "{$this->attributes['percentage']}%";
        }

        return null;
    }

    /**
     * Devuelve el descuento en numero ej: 100 => 1, 10 => 0.1.
     */
    public function decimalPercentage()
    {
        if (isset($this->attributes['percentage'])) {
            return $this->attributes['percentage'] / 100;
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Funciones protegidas
    // --------------------------------------------------------------------------

    /**
     * chequea si el valor es punto flotante o no.
     * @param mixed $value
     */
    protected function isFloat($value)
    {
        if (is_float($value)) {
            return $value;
        }

        return false;
    }
}
