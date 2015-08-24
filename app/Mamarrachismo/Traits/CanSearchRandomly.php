<?php namespace Orbiagro\Mamarrachismo\Traits;

trait CanSearchRandomly
{
    /**
     * Busca aleatoriamente un recurso
     * @param  \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeRandom($query)
    {
        // por ahora ignorado, pendiente de ver si hay o no test por BD.
        // si (env('APP_ENV') == 'ntesting')
          // query orderByRaw('RANDOM()');

        $query->orderByRaw('RAND()');
    }
}
