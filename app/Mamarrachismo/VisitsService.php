<?php namespace App\Mamarrachismo;

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
        throw new \Exception("Error, es necesario especificar modelo valido.", 3);
        break;
    }

    $total = Cookie::get("{$model}s_{$id}");
    $total = ($total) ? ($total + 1) : 1;
    Cookie::queue("{$model}s.{$id}", $total);
    Cookie::queue("{$model}LastVisited", $id);
    if(!Cookie::get("{$model}VisitedAt")) $this->setUpdatedCookieDate($model);
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
        throw new \Exception("Error, es necesario especificar modelo valido.", 2);
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
    $array = Transformer::getArrayByKeyValue("/(products\_)+/", Cookie::get());
    $parsed = $this->parseIdsInArrayKeys($array);

    if(!empty($parsed))
    {
      foreach ($parsed as $productID => $total) :
        $this->bag[] = $productID;
      endforeach;
      $this->storeProductsVisits($parsed);
    }

    if(Auth::user()) :
      if($visits = Auth::user()->visits()->where('visitable_type', 'App\Product')->with('visitable')->get()) :
        foreach ($visits as $visit) {
          $this->bag[] = $visit->visitable->id;
        }
        $products = Product::find($this->bag);
        $products->load('user', 'sub_category');
        return $products;
      endif;
    endif;

    return Product::find($this->bag);
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
    $array = Transformer::getArrayByKeyValue("/(subCats\_)+/", Cookie::get());
    $parsed = $this->parseIdsInArrayKeys($array);

    if(!empty($parsed))
    {
      foreach ($parsed as $subCatId => $total) :
        $this->bag[] = $subCatId;
      endforeach;
      $this->storeSubCatsVisits($parsed);
    }

    if(Auth::user()) :
      if($visits = Auth::user()->visits()->where('visitable_type', 'App\SubCategory')->with('visitable')->get()) :
        foreach ($visits as $visit) {
          $this->bag[] = $visit->visitable->id;
        }
        return SubCategory::find($this->bag);
      endif;
    endif;

    return SubCategory::find($this->bag);
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
   * @param array $array el array a iterar (id => visitas).
   *
   * @return void
   */
  private function storeProductsVisits($array)
  {
    if(!Auth::user()) return null;

    if(!isset($array)) return null;

    $date = Cookie::get("productVisitedAt");

    if(!$date) return null;

    if($date->diffInMinutes() < 5) return null;

    // si la visita no existe en la base de datos se crea, sino se actualiza
    foreach($array as $id => $total) :
      if($product = Product::find($id)) :
        if(Auth::user()->visits()->where('visitable_id', $product->id)->get()->isEmpty()) :
          $visit = new Visit;
          $visit->total = $total;
          $visit->user_id = Auth::user()->id;
          $product->visits()->save($visit);
        else:
          $visit = Auth::user()->visits()->where('visitable_id', $product->id)->first();
          $visit->total += $total;
          $visit->save();
        endif;
      endif;

      // se resetea el contador a 1 o 0 dependiendo de la ultima visita.
      if(intval(Cookie::get('productLastVisited')) == $id) :
        Cookie::queue("products.{$id}", 1);
      else:
        // se elimina el contador.
        Cookie::queue("products.{$id}", 0);
      endif;
    endforeach;
    // se actualiza la fecha de edicion del cookie
    $this->setUpdatedCookieDate('product');
  }

  /**
   * guarda las visitas de rubros del usuario en la base de datos.
   *
   * @param array $array el array a iterar (id => visitas).
   *
   * @return void
   */
  private function storeSubCatsVisits($array)
  {
    if(!Auth::user()) return null;

    if(!isset($array)) return null;

    $date = Cookie::get("subCatVisitedAt");

    if(!$date) return null;

    if($date->diffInMinutes() < 5) return null;

    // si la visita no existe en la base de datos se crea, sino se actualiza
    foreach($array as $id => $total) :
      if($subCat = SubCategory::find($id)) :
        if(Auth::user()->visits()->where('visitable_id', $subCat->id)->get()->isEmpty()) :
          $visit = new Visit;
          $visit->total = $total;
          $visit->user_id = Auth::user()->id;
          $subCat->visits()->save($visit);
        else:
          $visit = Auth::user()->visits()->where('visitable_id', $subCat->id)->first();
          $visit->total += $total;
          $visit->save();
        endif;
      endif;

      // se resetea el contador a 1 o 0 dependiendo de la ultima visita.
      if(intval(Cookie::get('subCatLastVisited')) == $id) :
        Cookie::queue("subCats.{$id}", 1);
      else:
        // se elimina el contador.
        Cookie::queue("subCats.{$id}", 0);
      endif;
    endforeach;
    // se actualiza la fecha de edicion del cookie
    $this->setUpdatedCookieDate('subCat');
  }

  /**
   * para darle una fecha al cookie
   *
   * @return void
   */
  private function setUpdatedCookieDate($model)
  {
    $carbon = Carbon::now();
    $date = $carbon;
    switch ($model) {
      case 'product':
        Cookie::queue("productVisitedAt", $date);
        break;
      case 'subCat':
        Cookie::queue("subCatVisitedAt", $date);
        break;

      default:
        throw new \Exception("La fecha del cookie de visita no pudo ser procesada", 1);
        break;
    }
  }
}
