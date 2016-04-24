<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orbiagro\Mamarrachismo\CheckDollar;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\HasShortTitle;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Transformer;

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
 * @property-read \Orbiagro\Models\Direction $direction
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\File[] $files
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Image[] $images
 * @property-read \Orbiagro\Models\Image $image
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
 * @mixin \Eloquent
 */
class Product extends Model
{

    use SoftDeletes, InternalDBManagement, CanSearchRandomly, HasShortTitle;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'maker_id',
        'sub_category_id',
        'title',
        'description',
        'heroDetails',
        'price',
        'quantity',
        'slug',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var \Orbiagro\Mamarrachismo\CheckDollar
     */
    protected $checkDollar;

    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ModelValidation::byLenght($value);

        if ($this->attributes['title']) {
            $this->attributes['slug'] = str_slug($this->attributes['title']);
        }
    }

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    /**
     * @param $value
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
     */
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = (integer)ModelValidation::byNonNegative($value);
    }

    /**
     * @param $value
     * @return float|mixed|null
     */
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

    /**
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
     * regresa los eventos paginados
     *
     * @return object LengthAwarePaginator
     */
    public function getPaginateAttribute()
    {
        return $this->get()->paginate(5);
    }

    /**
     * @param $value
     * @return float|null
     */
    public function getPriceAttribute($value)
    {
        if (isset($value) && $value > 0) {
            return (double)$value;
        }

        return null;
    }


    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @return mixed
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function characteristics()
    {
        return $this->hasOne(Characteristic::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function mechanical()
    {
        return $this->hasOne(MechanicalInfo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function nutritional()
    {
        return $this->hasOne(Nutritional::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Builder
     */
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Builder
     */
    public function purchases()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * @return $this|\Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Builder
     */
    public function providers()
    {
        return $this->belongsToMany(Provider::class)->withPivot('sku');
    }

    /**
     * Relacion polimorfica
     * $a->product()->first()->direction()->save($b)
     * en donde $a es una instancia de User y
     * $b es una instancia de Direction
     *
     * @link http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\Illuminate\Database\Eloquent\Builder
     */
    public function direction()
    {
        return $this->morphOne(Direction::class, 'directionable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|\Illuminate\Database\Eloquent\Builder
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|\Illuminate\Database\Eloquent\Builder
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\Illuminate\Database\Eloquent\Builder
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|\Illuminate\Database\Eloquent\Builder
     */
    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    /**
     * @param \Orbiagro\Mamarrachismo\CheckDollar $checkDollar
     * @return $this
     */
    public function setDollar(CheckDollar $checkDollar)
    {
        $this->checkDollar = $checkDollar;

        return $this;
    }

    /**
     * Determina el precio en dolares del producto.
     *
     * @param \Orbiagro\Mamarrachismo\CheckDollar|null $checkDollar
     * @return null|string
     */
    public function priceDollar(CheckDollar $checkDollar = null)
    {
        // si el objeto fue pasado como parametro
        if ($checkDollar !== null && $checkDollar->isValid()) {
            $dollar = $this->checkDollar($checkDollar);

            // si el objeto existe como atributo
        } elseif ($checkDollar === null && isset($this->CheckDollar)) {
            $dollar = $this->checkDollar($this->CheckDollar);

            // si no fue pasado ningun parametro
        } elseif ($checkDollar === null) {
            $checkDollar = new CheckDollar;

            $dollar = $this->checkDollar($checkDollar);
        }

        // si existe un $dollar y existe el precio del producto:
        if (isset($dollar) && isset($this->attributes['price'])) {
            $value = (int)$this->attributes['price'] / $dollar;

            return "\$ " . Transformer::toReadable($value);
        }

        return null;
    }

    /**
     * Determina y devuelve el promedio de dolar.
     *
     * @param \Orbiagro\Mamarrachismo\CheckDollar|null $checkDollar
     * @return null
     */
    public function checkDollar(CheckDollar $checkDollar = null)
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

    /**
     * Genera en formato legible el precio en Bolivares del producto.
     *
     * @param null $otherNumber
     * @return mixed|null|string
     */
    public function priceBs($otherNumber = null)
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

    /**
     * Genera el precio en formato legible sin el Bs.
     *
     * @return null|string
     */
    public function priceFormatted()
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
