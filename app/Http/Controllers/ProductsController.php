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
    $products = Product::paginate(5);

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

    // var_dump($request->cookie());

    return view('product.show', compact('product'));
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

    return view('product.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, ProductRequest $request)
  {
    return $request->all();
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

  private function notOwner($id)
  {
    if(Auth::user()->id === $id) return false;
    if(Auth::user()->isAdmin()) return false;

    return true;
  }

  private function getVisitedProducts()
  {
    $bag = [];
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

  private function storeVisits($array)
  {
    if(!Auth::user()) return null;

    if(!isset($array)) return null;

    $date = Cookie::get("visitedAt");

    if(!$date) return null;

    // if($date->diffInMinutes() < 5) return null;

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
      // Cookie::queue("products.{$id}", null);
    endforeach;
    // $this->setUpdatedCookieDate();
  }

  /**
   * http://php.net/manual/en/function.preg-grep.php#111673
   */
  private function preg_grep_keys($pattern, $input, $flags = 0)
  {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
  }

  private function setNewProductVisit($id)
  {
    $total = Cookie::get("products_{$id}");
    $total = ($total) ? ($total + 1) : 1;
    Cookie::queue("products.{$id}", $total);
    $this->setUpdatedCookieDate();
  }

  private function setUpdatedCookieDate()
  {
    $carbon = Carbon::now();
    $date = $carbon;
    Cookie::queue("visitedAt", $date);
  }

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
