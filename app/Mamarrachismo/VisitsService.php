<?php namespace Orbiagro\Mamarrachismo;

use Auth;
use Cookie;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\Visit;

/**
 * clase utilizada para buscar y crear nuevas
 * visitas de un usuario a un producto
 */
class VisitsService
{

    /**
     * Para almacenar Ids de los modelos a manipular.
     * @var array
     */
    protected $bag = [];

    // --------------------------------------------------------------------------
    // Funciones Publicas
    // --------------------------------------------------------------------------

    /**
     * @param Model|mixed $model
     *
     * @throws Exception
     */
    public function setNewVisit(Model $model)
    {
        switch (get_class($model)) {
            case 'Orbiagro\Models\SubCategory':
                $this->setNewVisitCookie($model);
                break;

            case 'Orbiagro\Models\Product':
                // para el caso del producto, se debe guardar
                // tanto el mismo como su rubro para obtener las visitas y populares
                $this->setNewVisitCookie($model);

                $this->setNewVisitCookie($model->subCategory);
                break;

            default:
                throw new Exception('Es necesario especificar modelo valido.');

        }
    }

    /**
     * @param string $model    el objeto a manipular.
     * @param int    $quantity la cantidad a tomar.
     *
     * @return Collection
     */
    public function getPopular($model, $quantity = 3)
    {
        $results = $this->findMostVisitedResource($model, $quantity);

        if ($results->isEmpty()) {
            return $results;
        }

        $results->each(function ($result) {
            $this->bag[] = $result->visitable_id;
        });

        return $model::find($this->bag);
    }

    /**
     * busca los productos dentro de los cookies y devuelve la coleccion.
     *
     * @param string $obj el objeto a manipular.
     * @return Collection
     */
    public function getVisitedResources($obj)
    {
        $result = $this->checkAndStoreVisits($obj);

        $visitedResources = $this->findVisitedResource($obj);

        if ($visitedResources->isEmpty()) {
            return $this->findResourceInDatabase($obj, $result);
        }

        return $visitedResources;
    }

    // --------------------------------------------------------------------------
    // Funciones privadas
    // --------------------------------------------------------------------------

    /**
     * usado para determinar cuales son los recursos mas populares (count)
     *
     * @param string $model    el modelo, nos interesa la clase (Orbiagro\Models\Product)
     * @param int   $quantity la cantidad a tomar
     *
     * @return Collection
     */
    private function findMostVisitedResource($model, $quantity)
    {
        return Visit::selectRaw('visitable_id, sum(total)')
            ->where('visitable_type', $model)
            ->groupBy('visitable_id')
            ->orderBy('total', 'desc')
            ->take($quantity)
            ->get();
    }

    /**
     * utilizado para obtener los recursos guardados en cookies.
     *
     * @param string $model
     * @param array $array el arreglo con ids a buscar.
     *
     * @return Collection
     */
    private function findResourceInDatabase($model, array $array)
    {
        foreach ($array as $id) {
            $this->bag[] = $id;
        }

        return $model::find($this->bag);
    }

    /**
     * itera el array de los productos visitados y lo
     * cambia para que sea mas facil de manipular.
     *
     * @example ['product_x' => y] ---> [x => y]
     *
     * @param array $array el array a iterar.
     *
     * @return array
     */
    private function parseIdsInArrayKeys(array $array)
    {
        $parsed = [];

        foreach ($array as $key => $value) {
            $exploted = explode('_', $key);
            $parsed[$exploted[1]] = $value;
        }

        return $parsed;
    }

    /**
     * guarda las visitas a productos del usuario en la base de datos.
     *
     * @param string $model el modelo a manipular.
     * @param array  $array el array a iterar (id => visitas).
     *
     * @return boolean
     */
    private function storeResourceVisits($model, array $array)
    {
        $name = class_basename($model);

        if (!$name) {
            throw new Exception('No se puede guardar visita sin un modelo asociado.');
        }

        $date = Cookie::get("{$name}VisitedAt");

        if (!Auth::user() || !isset($array) || !$date) {
            return null;
        }

        if ($date->diffInMinutes() < 5) {
            return null;
        }

        $this->createVisitModel($array, $name, $model);

        // se actualiza la fecha de edicion del cookie
        return $this->setUpdatedCookieDate($model);
    }

    /**
     * Usado para crear el modelo relacion al recurso, en este caso una visita.
     * @param  array $array el arreglo con los productos a relacionar
     * @param  string $name el nombre del recurso (Product, SubCategory, etc)
     * @param  string $model el modelo a manipular.
     * @throws Exception
     */
    private function createVisitModel(array $array, $name, $model)
    {
        if (gettype($model) !== 'string') {
            throw new Exception('El modelo especificado no es del tipo adecuado');
        }

        // si la visita no existe en la base de datos se crea, sino se actualiza
        foreach ($array as $id => $total) {
            // se busca el modelo
            if (!$result = $model::where('slug', $id)->first()) {
                $result = $model::find($id);
            }

            // si no hay resultado se continua iterando
            if (!$result) {
                continue;
            }

            // se determina si hay o no que crear una nueva visita
            if (Auth::user()->visits()->where('visitable_id', $result->id)->get()->isEmpty()) {
                $visit = new Visit;
                $visit->total = $total;
                $visit->user_id = Auth::user()->id;
                $result->visits()->save($visit);
            } elseif ($visit = Auth::user()->visits()->where('visitable_id', $result->id)->first()) {
                $visit->total += $total;
                $visit->save();
            }

            // se resetea el contador a 1 o 0 dependiendo de la ultima visita.
            $value = intval(Cookie::get("{$name}LastVisited")) == $id ? 1 : 0;

            Cookie::queue("{$name}.{$id}", $value);
        }
    }

    /**
     * para darle una fecha al cookie
     *
     * @param  string $model el tipo de modelo al que se le asociara el cookie
     * @return boolean
     */
    private function setUpdatedCookieDate($model)
    {
        $date = Carbon::now();

        $name = class_basename($model);

        return Cookie::queue("{$name}VisitedAt", $date);
    }

    /**
     * Crea un cookie relacionado a una vistita de algun recurso,
     * ya sea un producto, rubro u otro tipo, genera el total y crea
     * la fecha de la ultima visita para control.
     *
     * @method setNewVisitCookie
     *
     * @param  Model $model el nombre del modelo asociado
     *
     * @return void
     */
    private function setNewVisitCookie(Model $model)
    {
        $name = class_basename($model);

        $total = Cookie::get("{$name}_{$model->slug}");
        $total = ($total) ? ($total + 1) : 1;

        Cookie::queue("{$name}.{$model->slug}", $total);
        Cookie::queue("{$name}LastVisited", $model->id);

        if (!Cookie::get("{$name}VisitedAt")) {
            $this->setUpdatedCookieDate($model);
        }
    }

    /**
     * busca en las cookies guardadas del usuario e
     * invoca storeResourceVisits para guardar las visitas.
     *
     * @method checkAndStoreVisits
     *
     * @param  string $model El nombre del modelo
     *
     * @return array
     */
    private function checkAndStoreVisits($model)
    {
        $key = class_basename($model);

        // se procesan las cookies del usuario
        $array = Transformer::getArrayByKeyValue("/({$key}\_)+/", Cookie::get());
        $parsed = $this->parseIdsInArrayKeys($array);

        if (!empty($parsed)) {
            // findVisitedResource regresa una coleccion.
            $this->storeResourceVisits($model, $parsed);

            return $parsed;
        }

        return [];
    }

    /**
     * Busca las visitas e itera para encontrar la coleccion
     * de objetos (visitas de productos, rubros, etc)
     * relacionados con el usuario.
     *
     * @method findVisitedResource
     *
     * @param  string $model El modelo a manipular.
     *
     * @return Collection
     */
    private function findVisitedResource($model)
    {
        if (!Auth::user()) {
            return collect();
        }

        // se buscan las visitas que tengan
        // el tipo de visitable igual al model solicitado,
        // junto con el visitable (Producto, Rubro, Etc)
        $visits = Auth::user()
            ->visits()
            ->where('visitable_type', $model)
            ->with('visitable')
            ->get();

        if (!$visits) {
            return $visits;
        }

        foreach ($visits as $visit) {
            // visitable es el producto o subcategoria
            // se chequea para ver si hay o no modelo (visitable->id)
            if ($visit->visitable) {
                $this->bag[] = $visit->visitable->id;
            }

        }

        return $model::find($this->bag);
    }
}
