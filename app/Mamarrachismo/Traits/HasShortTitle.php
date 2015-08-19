<?php namespace App\Mamarrachismo\Traits;

trait HasShortTitle
{
  public function shortTitle($length = 32)
  {
    if (isset($this->attributes['title']))
    {
      return str_limit($this->attributes['title'], $length);
    }
    elseif(isset($this->attributes['description']))
    {
      return str_limit($this->attributes['description'], $length);
    }
    elseif(isset($this->attributes['name']))
    {
      return str_limit($this->attributes['name'], $length);
    }

    return null;
  }
}
