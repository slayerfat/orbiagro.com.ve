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
   * @param int $id id del producto visitado.
   *
   * @return void
   */
  public function setNewVisit($model = null, $id)
  {
    switch (ucfirst($model))
    {
      case 'SubCategory':
      case 'SubCategories':
      case 'SubCat':
      case 'SubCats':
        $model = 'subCat';
        break;
      case 'Product':
      case 'Products':
        $model = 'product';
        break;

      default:
        throw new Exception("Error, es necesario especificar modelo valido.", 3);
        break;
    }

    $this->setNewVisitCookie($model, $id);
  }

  /**
   * @param string  $className  el nombre de la clase.
   * @param int     $quantity   la cantidad a tomar.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getPopular($className = null, $quantity = 3)
  {
    switch (ucfirst($className))
    {
      case 'SubCategory':
      case 'SubCat':
        $class = new SubCategory;
        break;
      case 'Product':
        $class = new Product;
        break;

      default:
        throw new Exception("Error, es necesario especificar modelo valido.", 2);
        break;
    }

    $results = Visit::selectRaw('visitable_id, sum(total)')
      ->where('visitable_type', get_class($class))
      ->groupBy('visitable_id')
      ->orderBy('total', 'desc')
      ->take($quantity)
      ->get();
    $results->each(function($result){
      $this->bag[] = $result->visitable_id;
    });

    return $class->with('products')->find($this->bag);
  }

  // --------------------------------------------------------------------------
  // Productos
  // --------------------------------------------------------------------------

  /**
   * busca los productos dentro de los cookies y devuelve la coleccion.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getVisitedProducts()
  {
    $this->checkAndStoreVisits(new Product);

    return $this->findVisitedResource('Product');
  }

  // --------------------------------------------------------------------------
  // Rubros
  // --------------------------------------------------------------------------

  /**
   * busca los rubros dentro de los cookies y devuelve la coleccion.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getVisitedSubCats()
  {
    $this->checkAndStoreVisits(new subCategory);

    return $this->findVisitedResource('App\SubCategory');
  }

  // --------------------------------------------------------------------------
  // Funciones privadas
  // --------------------------------------------------------------------------


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

    $upperModel = (new \ReflectionClass($model))->getShortName();

    if (!$upperModel)
    {
      throw new Exception("No se puede guardar visita sin un modelo asociado", 4);
    }
    $lowerModel = strtolower($upperModel);

    $date = Cookie::get("{$lowerModel}VisitedAt");

    if(!$date) return null;

    if($date->diffInMinutes() < 5) return null;

    // si la visita no existe en la base de datos se crea, sino se actualiza
    foreach($array as $id => $total) :

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
      if(intval(Cookie::get("{$lowerModel}LastVisited")) == $id) :
        Cookie::queue("{$lowerModel}s.{$id}", 1);
      else:
        // se elimina el contador.
        Cookie::queue("{$lowerModel}s.{$id}", 0);
      endif;
    endforeach;
    // se actualiza la fecha de edicion del cookie
    return $this->setUpdatedCookieDate($lowerModel);
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
    switch ($model)
    {
      case 'Product':
      case 'product':
        return Cookie::queue("productVisitedAt", $date);
        break;
      case 'SubCategory':
      case 'subcategory':
      case 'subCat':
        return Cookie::queue("subCatVisitedAt", $date);
        break;

      default:
        throw new Exception("La fecha del cookie de visita no pudo ser procesada", 1);
        break;
    }
  }

  /**
   * Crea un cookie relacionado a una vistita de algun recurso,
   * ya sea un producto, rubro u otro tipo, genera el total y crea
   * la fecha de la ultima visita para control.
   *
   * @method setNewVisitCookie
   * @param  string            $model el nombre del modelo asociado
   * @param  int               $id    el id del modelo a asociar
   */
  private function setNewVisitCookie($model, $id)
  {
    $total = Cookie::get("{$model}s_{$id}");
    $total = ($total) ? ($total + 1) : 1;

    Cookie::queue("{$model}s.{$id}", $total);
    Cookie::queue("{$model}LastVisited", $id);

    if(!Cookie::get("{$model}VisitedAt")) $this->setUpdatedCookieDate($model);
  }

  /**
   * busca en las cookies guardadas del usuario e
   * invoca storeResourceVisits para guardar las visitas.
   *
   * @method checkAndStoreVisits
   * @param  string              $model El nombre del modelo
   * @return boolean
   */
  private function checkAndStoreVisits($model)
  {
    // por ahora el key se implementa asi porque
    // solo estan contemplados por ahora dos
    // recursos que seran visitados.
    $key = (new \ReflectionClass($model))
      ->getShortName() == 'SubCategory' ? 'subCats' : 'products';

    // se procesan las cookies del usuario
    $array = Transformer::getArrayByKeyValue("/({$key}\_)+/", Cookie::get());
    $parsed = $this->parseIdsInArrayKeys($array);

    if(!empty($parsed)) return null;

    // solo se regresa esto porque findVisitedResource regresa
    // tambien una coleccion, asi que es redundante
    // buscar y regresar una coleccion en este metodo.
    return $this->storeResourceVisits($model, $parsed);

    // foreach ($parsed as $id => $total) :
    //   $this->bag[] = $id;
    // endforeach;
    //
    // $this->storeResourceVisits($model, $parsed);
    //
    // return $model::find($this->bag);
  }

  /**
   * Busca las visitas e itera para encontrar la coleccion
   * de objetos (visitas de productos, rubros, etc)
   * relacionados con el usuario.
   *
   * @method findVisitedResource
   * @param  string               $model El modelo a manipular.
   * @return Collection | boolean
   */
  private function findVisitedResource($model)
  {
    if(!Auth::user()) return null;

    // se buscan las visitas que tengan
    // el tipo de visitable igual al model solicitado,
    // junto con el visitable (Producto, Rubro, Etc)
    $visits = Auth::user()
                ->visits()
                ->where('visitable_type', "App\{$model}")
                ->with('visitable')
                ->get();

    if(!$visits) return null;

    foreach ($visits as $visit)
    {
      // visitable es el producto o subcategoria
      // se chequea para ver si hay o no modelo (visitable->id)
      if ($visit->visitable)
      {
        $this->bag[] = $visit->visitable->id;
      }
    }

    $result = $model::find($this->bag);

    if ($model == 'Product')
    {
      $result->load('user', 'subCategory');
    }

    return $result;
  }
}
