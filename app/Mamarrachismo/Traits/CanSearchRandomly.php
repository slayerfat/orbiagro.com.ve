<?php namespace App\Mamarrachismo\Traits;

trait CanSearchRandomly
{
  public function scopeRandom($query)
  {
    // por ahora ignorado, pendiente de ver si hay o no test por BD.
    // if (env('APP_ENV') == 'ntesting')
      // $query->orderByRaw('RANDOM()');

    $query->orderByRaw('RAND()');
  }
}
