<?php namespace App\Mamarrachismo;

use Exception;
Use Auth;
Use Cookie;
Use Carbon\Carbon;

Use App\Mamarrachismo\Transformer;

Use App\Product;
Use App\SubCategory;
Use App\Visit;

/**
 * clase utilizada para buscar y crear nuevas
 * visitas de un usuario a un producto
 */
class VisitsService {

  /**
   * Para almacenar Ids de los modelos a manipular.
   * @var array
   */
  protected $bag = [];

  // --------------------------------------------------------------------------
  // Funciones Publicas
  // --------------------------------------------------------------------------

  /**
   * @param mixed $model el modelo a manipular.
   *
   * @return void
   */
  public function setNewVisit($model)
  {
    switch (get_class($model))
    {
      case 'App\SubCategory':
      case 'App\Product':
        return $this->setNewVisitCookie($model);

      default:
        throw new Exception("Error, es necesario especificar modelo valido.", 3);

    }
  }

  /**
   * @param mixed  $model     el objeto a manipular.
   * @param int    $quantity  la cantidad a tomar.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getPopular($model, $quantity = 3)
  {
    $results = $this->findMostVisitedResource($model, $quantity);

    if ($results->isEmpty()) return $results;

    $results->each(function($result){
      $this->bag[] = $result->visitable_id;
    });

    return $model->find($this->bag);
  }

  /**
   * busca los productos dentro de los cookies y devuelve la coleccion.
   *
   * @param mixed $obj el objeto a manipular.
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getVisitedResources($obj)
  {
    $result = $this->checkAndStoreVisits($obj);

    $visitedResources = $this->findVisitedResource($obj);

    if ($visitedResources->isEmpty())
    {
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
   * @param mixed $model    el modelo, nos interesa la clase (App\Product)
   * @param int   $quantity la cantidad a tomar
   *
   * @return Collection
   */
  private function findMostVisitedResource($model, $quantity)
  {
    return Visit::selectRaw('visitable_id, sum(total)')
      ->where('visitable_type', get_class($model))
      ->groupBy('visitable_id')
      ->orderBy('total', 'desc')
      ->take($quantity)
      ->get();
  }

  /**
   * utilizado para obtener los recursos guardados en cookies.
   *
   * @param mixed $model
   * @param array $array el arreglo con ids a buscar.
   *
   * @return Collection
   */
  private function findResourceInDatabase($model, $array)
  {
    foreach ($array as $id) :
      $this->bag[] = $id;
    endforeach;

    return $model::find($this->bag);
  }
  /**
   * itera el array de los productos visitados y lo
   * cambia para que sea mas facil de manipular
   * ['product_x' => y] ---> [x => y]
   *
   * @param array $array el array a iterar.
   *
   * @return array
   */
  private function parseIdsInArrayKeys($array)
  {
    $parsed = [];
    foreach ($array as $key => $value)
    {
      $exploted = explode('_', $key);
      $parsed[$exploted[1]] = $value;
    }
    return $parsed;
  }

  /**
   * guarda las visitas a productos del usuario en la base de datos.
   *
   * @param array  $array el array a iterar (id => visitas).
   * @param Object $model el modelo a manipular.
   *
   * @return boolean
   */
  private function storeResourceVisits($model, $array)
  {
    if(!Auth::user()) return null;

    if(!isset($array)) return null;

    $name = $this->findReflectionClassName($model);

    if (!$name)
    {
      throw new Exception("No se puede guardar visita sin un modelo asociado", 4);
    }

    $date = Cookie::get("{$name}VisitedAt");

    if(!$date) return null;

    if($date->diffInMinutes() < 5) return null;

    $this->createVisitModel($array, $name, $model);

    // se actualiza la fecha de edicion del cookie
    return $this->setUpdatedCookieDate($model);
  }

  /**
   * Usado para crear el modelo relacion al recurso, en este caso una visita.
   * @param  array  $array el arreglo con los productos a relacionar
   * @param  string $name  el nombre del recurso (Product, SubCategory, etc)
   * @param  Object $model el modelo a manipular.
   * @return void
   */
  private function createVisitModel($array, $name, $model)
  {
    // si la visita no existe en la base de datos se crea, sino se actualiza
    foreach($array as $id => $total) :

      if(!$model = $model::where('slug', $id)->first())
        $model = $model::findOrFail($id);

      if(Auth::user()->visits()->where('visitable_id', $model->id)->get()->isEmpty()) :
        $visit = new Visit;
        $visit->total = $total;
        $visit->user_id = Auth::user()->id;
        $model->visits()->save($visit);
      else:
        $visit = Auth::user()->visits()->where('visitable_id', $model->id)->first();
        $visit->total += $total;
        $visit->save();
      endif;

      // se resetea el contador a 1 o 0 dependiendo de la ultima visita.
      $value = intval(Cookie::get("{$name}LastVisited")) == $id ? 1 : 0;

      Cookie::queue("{$name}.{$id}", $value);
    endforeach;
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

    $name = $this->findReflectionClassName($model);

    return Cookie::queue("{$name}VisitedAt", $date);
  }

  /**
   * Crea un cookie relacionado a una vistita de algun recurso,
   * ya sea un producto, rubro u otro tipo, genera el total y crea
   * la fecha de la ultima visita para control.
   *
   * @method setNewVisitCookie
   * @param  mixed             $model el nombre del modelo asociado
   */
  private function setNewVisitCookie($model)
  {
    $name = $this->findReflectionClassName($model);

    $total = Cookie::get("{$name}_{$model->slug}");
    $total = ($total) ? ($total + 1) : 1;

    Cookie::queue("{$name}.{$model->slug}", $total);
    Cookie::queue("{$name}LastVisited", $model->id);

    if(!Cookie::get("{$name}VisitedAt")) $this->setUpdatedCookieDate($model);
  }

  /**
   * busca en las cookies guardadas del usuario e
   * invoca storeResourceVisits para guardar las visitas.
   *
   * @method checkAndStoreVisits
   * @param  string              $model El nombre del modelo
   * @return mixed
   */
  private function checkAndStoreVisits($model)
  {
    $key = $this->findReflectionClassName($model);

    // se procesan las cookies del usuario
    $array = Transformer::getArrayByKeyValue("/({$key}\_)+/", Cookie::get());
    $parsed = $this->parseIdsInArrayKeys($array);

    if(!empty($parsed))
    {
      // findVisitedResource regresa una coleccion.
      $this->storeResourceVisits($model, $parsed);

      return $parsed;
    }

    return collect();
  }

  /**
   * Busca las visitas e itera para encontrar la coleccion
   * de objetos (visitas de productos, rubros, etc)
   * relacionados con el usuario.
   *
   * @method findVisitedResource
   * @param  string               $model El modelo a manipular.
   * @return Collection
   */
  private function findVisitedResource($model)
  {
    if(!Auth::user()) return collect();

    // se buscan las visitas que tengan
    // el tipo de visitable igual al model solicitado,
    // junto con el visitable (Producto, Rubro, Etc)
    $visits = Auth::user()
                ->visits()
                ->where('visitable_type', get_class($model))
                ->with('visitable')
                ->get();

    if(!$visits) return $visits;

    foreach ($visits as $visit)
    {
      // visitable es el producto o subcategoria
      // se chequea para ver si hay o no modelo (visitable->id)
      if ($visit->visitable)
      {
        $this->bag[] = $visit->visitable->id;
      }
    }

    if (get_class($model) == 'Product')
    {
      return $model->load('user', 'subCategory');
    }

    return $model->find($this->bag);
  }

  /**
   * genera el nombre de la clase sin el namespace:
   * Algun\Namespace\Clase => Clase
   *
   * @param mixed $obj
   * @return string
   */
  public function findReflectionClassName($obj)
  {
    return (new \ReflectionClass($obj))->getShortName();
  }
}
