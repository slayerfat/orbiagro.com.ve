<?php namespace App\Http\Controllers;

use Auth;
use Cookie;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Visit;
use App\MapDetail;
use App\Direction;
use App\Maker;

class ProductsController extends Controller {


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $products = Product::paginate(20);

    return view('product.index', compact('products'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id, Request $request)
  {
    if(!$product = Product::where('slug', $id)->first())
    $product = Product::findOrFail($id);

    $this->setNewProductVisit($product->id);
    $visitedProducts = $this->getVisitedProducts();

    return view('product.show', compact('product', 'visitedProducts'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    if($this->notOwner($id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;
    if($product = Product::where('slug', $id)->first())

    return view('product.edit', compact('product'));

    $product = Product::findOrFail($id);

    $makers = Maker::lists('name', 'id');

    return view('product.edit', compact('product', 'makers'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, ProductRequest $request)
  {
    if($this->notOwner($id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;

    $product = Product::findOrFail($id);
    $product->update($request->all());

    $map = new MapDetail($request->all());

    $direction = new Direction($request->all());

    $product->direction->save([$direction]);

    $product->direction->map()->save($map);

    flash('El Producto ha sido actualizado con exito.');
    return redirect()->action('ProductsController@show', $id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

  /**
   * Para saber si el usuario es o no el dueño
   * de un producto para editar.
   *
   * @param int $id user's id.
   *
   * @return boolean
   */
  private function notOwner($id)
  {
    if(Auth::user()->id === $id) return false;
    if(Auth::user()->isAdmin()) return false;

    return true;
  }

  /**
   * busca los productos dentro de los cookies y devuelve la coleccion.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  private function getVisitedProducts()
  {
    $bag = [];

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

    $array = $this->preg_grep_keys("/(products\_)+/", Cookie::get());
    $parsed = $this->parseProductIdInArrayKeys($array);

    if(!empty($parsed))
    {
      foreach ($parsed as $productID => $total) :
        $bag[] = $productID;
      endforeach;
      $this->storeVisits($parsed);
    }

    return Product::find($bag);
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
      // se resetea el contador.
      Cookie::queue("products.{$id}", 1);
    endforeach;
    // se actualiza la fecha de edicion del cookie
    $this->setUpdatedCookieDate();
  }

  /**
   * http://php.net/manual/en/function.preg-grep.php#111673
   *
   * @param $pattern string la expresion regular.
   * @param $input array el array a iterar.
   *
   * @return array
   */
  private function preg_grep_keys($pattern, $input, $flags = 0)
  {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
  }

  /**
   * @param int $id id del producto visitado.
   *
   * @return void
   */
  private function setNewProductVisit($id)
  {
    $total = Cookie::get("products_{$id}");
    $total = ($total) ? ($total + 1) : 1;
    Cookie::queue("products.{$id}", $total);
    if(!Cookie::get('visitedAt')) $this->setUpdatedCookieDate();
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

}
