<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\NutritionalRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Nutritional;

use App\Mamarrachismo\ModelValidation;

class NutritionalsController extends Controller {

  private $user, $userId, $nutritional;

  /**
   * Create a new controller instance.
   *
   * @method __construct
   * @param  Feature     $feature
   *
   * @return void
   */
  public function __construct(Nutritional $nutritional)
  {
    $this->middleware('auth');
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->modelValidator = new ModelValidation($this->userId, $this->user);
    $this->nutritional = $nutritional;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
    $product = Product::findOrFail($id)->load('nutritional');

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if ($product->nutritional) {
      flash()->error('Este Producto ya posee Valores Nutricionales, por favor actualice las existentes.');
      return redirect()->action('ProductsController@show', $product->slug);
    }

    return view('nutritional.create')->with([
      'product' => $product,
      'nutritional'    => $this->nutritional
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($id, NutritionalRequest $request)
  {
    $product = Product::findOrFail($id)->load('nutritional');

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if ($product->nutritional) :
      flash()->error('Este Producto ya posee Valores Nutricionales, por favor actualice las existentes.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    $this->nutritional = new Nutritional($request->all());
    $this->nutritional->created_by = $this->userId;
    $this->nutritional->updated_by = $this->userId;

    $product->nutritional()->save($this->nutritional);

    flash('Valores Nutricionales del producto creados exitosamente.');
    return redirect()->action('ProductsController@show', $product->slug);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $this->nutritional = Nutritional::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->nutritional->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $this->nutritional->product->slug);
    endif;

    return view('nutritional.edit')->with(['nutritional' => $this->nutritional]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, NutritionalRequest $request)
  {
    $this->nutritional = Nutritional::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->nutritional->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $this->nutritional->product->slug);
    endif;

    $this->nutritional->updated_by = $this->userId;
    $this->nutritional->update($request->all());

    flash('Valores Nutricionales del Producto Actualizados exitosamente.');
    return redirect()->action('ProductsController@show', $this->nutritional->product->slug);
  }

}
