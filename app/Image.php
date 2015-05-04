<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Mamarrachismo\ModelValidation;

class Image extends Model {

  protected $fillable = ['path', 'mime', 'alt'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setPathAttribute($value)
  {
    if($this->file_exists($value)):
      $this->attributes['path'] = $value;
    else:
      $this->attributes['path'] = null;
    endif;
  }

  public function setAltAttribute($value)
  {
    $this->attributes['alt'] = 'orbiagro.com.ve subastas compra y venta: '.str_slug($value);
  }

  // --------------------------------------------------------------------------
  // Accessors
  // --------------------------------------------------------------------------
  public function getPathAttribute($value)
  {
    if($value) return $value;
    return null;
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function imageable()
  {
    return $this->morphTo();
  }

  // --------------------------------------------------------------------------
  // Private Methods
  // --------------------------------------------------------------------------
  private function file_exists($path)
  {
    if(Storage::disk('public')->exists($path)):
      return true;
    elseif(Storage::disk('test')->exists($path)):
      return true;
    else:
      return false;
    endif;
  }

}
