<?php namespace App\Mamarrachismo;

Use Auth;
Use Cookie;
Use Carbon\Carbon;

Use App\Mamarrachismo\Transformer;

Use App\Product;
Use App\Visit;

/**
 * clase utilizada para buscar y crear nuevas
 * visitas de un usuario a un producto
 */
class VisitsService {

  // --------------------------------------------------------------------------
  // Funciones Publicas
  // --------------------------------------------------------------------------

  /**
   * busca los productos dentro de los cookies y devuelve la coleccion.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getVisitedProducts()
  {
    $bag = [];

    $array = Transformer::getArrayByKeyValue("/(products\_)+/", Cookie::get());
    $parsed = $this->parseProductIdInArrayKeys($array);

    if(!empty($parsed))
    {
      foreach ($parsed as $productID => $total) :
        $bag[] = $productID;
      endforeach;
      $this->storeVisits($parsed);
    }

    if(Auth::user()) :
      if($visits = Auth::user()->visits()->with('visitable')->get()) :
        foreach ($visits as $visit) {
          $bag[] = $visit->visitable->id;
        }
        $products = Product::find($bag);
        $products->load('user', 'sub_category');
        return $products;
      endif;
    endif;

    return Product::find($bag);
  }

  /**
   * @param int $id id del producto visitado.
   *
   * @return void
   */
  public function setNewProductVisit($id)
  {
    $total = Cookie::get("products_{$id}");
    $total = ($total) ? ($total + 1) : 1;
    Cookie::queue("products.{$id}", $total);
    Cookie::queue("lastVisitedProduct", $id);
    if(!Cookie::get('visitedAt')) $this->setUpdatedCookieDate();
  }

  /**
   * @param int $quantity la cantidad a tomar.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getPopularSubCats($quantity = 3)
  {
    return Visit::where('visitable_type', 'App\SubCategory')
      ->orderBy('total', 'desc')
      ->take($quantity)
      ->get();
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
  private function parseProductIdInArrayKeys($array)
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
  private function storeVisits($array)
  {
    if(!Auth::user()) return null;

    if(!isset($array)) return null;

    $date = Cookie::get("visitedAt");

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
      if(intval(Cookie::get('lastVisitedProduct')) == $id) :
        Cookie::queue("products.{$id}", 1);
      else:
        // se elimina el contador.
        Cookie::queue("products.{$id}", 0);
      endif;
    endforeach;
    // se actualiza la fecha de edicion del cookie
    $this->setUpdatedCookieDate();
  }

  /**
   * para darle una fecha al cookie
   *
   * @return void
   */
  private function setUpdatedCookieDate()
  {
    $carbon = Carbon::now();
    $date = $carbon;
    Cookie::queue("visitedAt", $date);
  }
}
