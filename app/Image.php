<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Image extends Model {

  use InternalDBManagement;

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
    $this->attributes['alt'] = str_slug($value).' en orbiagro.com.ve: subastas, compra y venta de productos y articulos en Venezuela.';
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
