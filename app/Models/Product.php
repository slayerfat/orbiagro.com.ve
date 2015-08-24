<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Transformer;

use Orbiagro\Mamarrachismo\CheckDollar;

use Illuminate\Database\Eloquent\SoftDeletes;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;

/**
 * Orbiagro\Models\Product
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $maker_id
 * @property integer $sub_category_id
 * @property string $title
 * @property string $description
 * @property string $heroDetails
 * @property float $price
 * @property integer $quantity
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $deleted_at
 * @property-read mixed $paginate
 * @property-read \Orbiagro\Models\User $user
 * @property-read \Orbiagro\Models\Maker $maker
 * @property-read \Orbiagro\Models\SubCategory $subCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Feature[] $features
 * @property-read \Orbiagro\Models\Characteristic $characteristics
 * @property-read \Orbiagro\Models\MechanicalInfo $mechanical
 * @property-read \Orbiagro\Models\Nutritional $nutritional
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Promotion[] $promotions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\User[] $purchases
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Provider[] $providers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\File[] $files
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Image[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Visit[] $visits
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereMakerId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereSubCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereHeroDetails($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product latest()
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Product random()
 */
class Product extends Model
{

    use SoftDeletes, InternalDBManagement, CanSearchRandomly, HasShortTitle;

    protected $fillable = [
        'user_id',
        'maker_id',
        'sub_category_id',
        'title',
        'description',
        'heroDetails',
        'price',
        'quantity',
        'slug'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $checkDollar;

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

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
    }

    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = (integer)ModelValidation::byNonNegative($value);
    }

    public function setPriceAttribute($value)
    {
        if (ModelValidation::byNonNegative($value)) {
            return $this->attributes['price'] = (double)$value;

        } elseif ($number = Transformer::toNumber($value)) {
            if ($number > 0) {
                return $this->attributes['price'] = $number;
            }
        }

        return $this->attributes['price'] = null;
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

    /**
     * regresa los eventos paginados
     * @return object LengthAwarePaginator
     */
    public function getPaginateAttribute()
    {
        return $this->get()->paginate(5);
    }

    public function getPriceAttribute($value)
    {
        if (isset($value) && $value > 0) {
            return (double)$value;
        }

        return null;
    }


    // --------------------------------------------------------------------------
    // Scopes
    // --------------------------------------------------------------------------
    public function scopeLatest($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function user()
    {
        return $this->belongsTo('Orbiagro\Models\User');
    }

    public function maker()
    {
        return $this->belongsTo('Orbiagro\Models\Maker');
    }

    public function subCategory()
    {
        return $this->belongsTo('Orbiagro\Models\SubCategory');
    }

    // --------------------------------------------------------------------------
    // Has Many
    // --------------------------------------------------------------------------
    public function features()
    {
        return $this->hasMany('Orbiagro\Models\Feature');
    }

    // --------------------------------------------------------------------------
    // Has One
    // --------------------------------------------------------------------------
    public function characteristics()
    {
        return $this->hasOne('Orbiagro\Models\Characteristic');
    }

    public function mechanical()
    {
        return $this->hasOne('Orbiagro\Models\MechanicalInfo');
    }

    public function nutritional()
    {
        return $this->hasOne('Orbiagro\Models\Nutritional');
    }

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------
    public function promotions()
    {
        return $this->belongsToMany('Orbiagro\Models\Promotion');
    }

    public function purchases()
    {
        return $this->belongsToMany('Orbiagro\Models\User')->withPivot('quantity')->withTimestamps();
    }

    public function providers()
    {
        return $this->belongsToMany('Orbiagro\Models\Provider')->withPivot('sku');
    }

    // --------------------------------------------------------------------------
    // Polymorphic
    //
    // Relacion polimorfica
    // http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
    //
    // $a->product()->first()->direction()->save($b)
    // en donde $a es una instancia de User y
    // $b es una instancia de Direction
    // --------------------------------------------------------------------------
    public function direction()
    {
        return $this->morphOne('Orbiagro\Models\Direction', 'directionable');
    }

    public function files()
    {
        return $this->morphMany('Orbiagro\Models\File', 'fileable');
    }

    public function images()
    {
        return $this->morphMany('Orbiagro\Models\Image', 'imageable');
    }

    public function image()
    {
        return $this->morphOne('Orbiagro\Models\Image', 'imageable');
    }

    public function visits()
    {
        return $this->morphMany('Orbiagro\Models\Visit', 'visitable');
    }

    // --------------------------------------------------------------------------
    // Metodos Publicos
    // --------------------------------------------------------------------------
    public function setDollar(CheckDollar $checkDollar)
    {
        $this->CheckDollar = $checkDollar;

        return $this;
    }

    public function check_dollar(CheckDollar $checkDollar = null)
    {
        // si existe un parametro y es valido
        if ($checkDollar !== null && $checkDollar->isValid()) {
            return $checkDollar->dollar->promedio;

            // no existe parametro pero existe como atributo
        } elseif ($checkDollar === null && isset($this->CheckDollar)) {
            if ($this->CheckDollar->isValid()) {
                return $this->CheckDollar->dollar->promedio;
            }

            // no existe ni parametro ni atributo
        } elseif ($checkDollar === null) {
            $obj = new CheckDollar;

            if ($obj->isValid()) {
                $this->CheckDollar = $obj;
                return $obj->dollar->promedio;
            }
        }

        return null;
    }

    public function price_dollar(CheckDollar $checkDollar = null)
    {
        // si el objeto fue pasado como parametro
        if ($checkDollar !== null && $checkDollar->isValid()) {
            $dollar = $this->check_dollar($checkDollar);

            // si el objeto existe como atributo
        } elseif ($checkDollar === null && isset($this->CheckDollar)) {
            $dollar = $this->check_dollar($this->CheckDollar);

            // si no fue pasado ningun parametro
        } elseif ($checkDollar === null) {
            $checkDollar = new CheckDollar;

            $dollar = $this->check_dollar($checkDollar);
        }

        // si existe un $dollar y existe el precio del producto:
        if ($dollar && isset($this->attributes['price'])) {
            (int)$value = $this->attributes['price'] / $dollar;

            return "\$ ".Transformer::toReadable($value);
        }

        return null;
    }

    public function price_bs($otherNumber = null)
    {
        if ($otherNumber) {
            return Transformer::toReadable($otherNumber);
        }

        if (!isset($this->attributes['price'])) {
            return null;
        }

        $price = Transformer::toReadable($this->attributes['price']);

        return "Bs. {$price}";
    }

    public function price_formatted()
    {
        if (isset($this->attributes['price'])) {
            $price = Transformer::toReadable($this->attributes['price']);

            return "{$price}";
        }

        return null;
    }

    /**
     * forceDeleting es el atributo relacionado cuando
     * algun modelo es eliminado de verdad
     * en la aplicacion.
     *
     * @return boolean
     */
    public function isForceDeleting()
    {
        return $this->forceDeleting;
    }
}
