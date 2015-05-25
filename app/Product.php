<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\CheckDollar as Dollar;
use App\Mamarrachismo\ModelValidation;
use App\Mamarrachismo\Transformer;

class Product extends Model {

  protected $fillable = [
    'user_id',
    'maker_id',
    'sub_category_id',
    'title',
    'description',
    'price',
    'quantity',
    'slug'
  ];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = ModelValidation::byLenght($value);
    if($this->attributes['title'])
      $this->attributes['slug'] = str_slug($this->attributes['title']);
  }

  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ModelValidation::byLenght($value);
  }

  public function setSlugAttribute($value)
  {
    if (ModelValidation::byLenght($value)) :
      $this->attributes['slug'] = str_slug($value);
    else:
      $this->attributes['slug'] = null;
    endif;
  }

  public function setQuantityAttribute($value)
  {
    $this->attributes['price'] = (integer)ModelValidation::byNonNegative($value);
  }

  public function setPriceAttribute($value)
  {
    $this->attributes['price'] = ModelValidation::byNonNegative($value);
  }

  // --------------------------------------------------------------------------
  // Accessors
  // --------------------------------------------------------------------------
  public function getTitleAttribute($value)
  {
    if($value) return ucfirst($value);
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

  // --------------------------------------------------------------------------
  // Scopes
  // --------------------------------------------------------------------------
  public function scopeRandom($query)
  {
    if (env('APP_ENV') == 'testing') {
      $query->orderByRaw('RANDOM()');
    }else{
      $query->orderByRaw('RAND()');
    }
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs To
  // --------------------------------------------------------------------------
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function maker()
  {
    return $this->belongsTo('App\Maker');
  }

  public function sub_category()
  {
    return $this->belongsTo('App\SubCategory');
  }

  // --------------------------------------------------------------------------
  // Has Many
  // --------------------------------------------------------------------------
  public function features()
  {
    return $this->hasMany('App\Feature');
  }

  // --------------------------------------------------------------------------
  // Has One
  // --------------------------------------------------------------------------
  public function characteristics()
  {
    return $this->hasOne('App\Characteristic');
  }

  public function mechanical()
  {
    return $this->hasOne('App\MechanicalInfo');
  }

  public function nutritional()
  {
    return $this->hasOne('App\Nutritional');
  }

  // --------------------------------------------------------------------------
  // Belongs To Many
  // --------------------------------------------------------------------------
  public function promotions()
  {
    return $this->belongsToMany('App\Promotion');
  }

  public function purchases()
  {
   return $this->belongsToMany('App\User')->withPivot('quantity')->withTimestamps();
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
    return $this->morphOne('App\Direction', 'directionable');
  }

  public function files()
  {
    return $this->morphMany('App\File', 'fileable');
  }

  public function images()
  {
    return $this->morphMany('App\Image', 'imageable');
  }

  public function visits()
  {
    return $this->morphMany('App\Visit', 'visitable');
  }

  // --------------------------------------------------------------------------
  // Metodos Publicos
  // --------------------------------------------------------------------------

  public function check_dollar()
  {
    $obj = new Dollar;
    if($obj->isValid()) return $obj->dollar->promedio;
    return null;
  }

  public function price_dollar()
  {
    $dollar = $this->check_dollar();

    if($dollar):
      $value = $this->attributes['price'] / $dollar;
      return "\${$value}";
    else:
      return null;
    endif;
  }

  public function price_bs()
  {
    $price = Transformer::toReadable($this->attributes['price']);
    if(isset($this->attributes['price'])) return "Bs. {$price}";
    return null;
  }

  public function price_formatted()
  {
    $price = Transformer::toReadable($this->attributes['price']);
    if(isset($this->attributes['price'])) return "{$price}";
    return null;
  }

}
