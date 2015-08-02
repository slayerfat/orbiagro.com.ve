<?php namespace App\Mamarrachismo\Traits;

trait CanSearchRandomly
{
  public function scopeRandom($query)
  {
    if (env('APP_ENV') == 'ntesting')
    {
      $query->orderByRaw('RANDOM()');
    }
    else
    {
      $query->orderByRaw('RAND()');
    }
  }
}
