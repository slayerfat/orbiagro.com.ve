<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

  protected $fillable = ['path', 'alt', 'created_by', 'updated_by'];

  /**
   * Mutators
   */
  public function setPathAttribute($value)
  {
    if($this->file_exists):
      $this->attributes['path'] = $value;
    else:
      $this->attributes['path'] = null;
    endif;
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function imageable()
  {
    return $this->morphTo();
  }

  /**
   * Private Methods
   */
  private function file_exists($path)
  {
    return Storage::exists($path);
  }

}
