<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests\CharacteristicRequest;
use App\Http\Controllers\Controller;

use App\Product;
use App\Characteristic;

use App\Mamarrachismo\ModelValidation;

class CharacteristicsController extends Controller {

  private $user, $userId, $characteristic;

  /**
   * Create a new controller instance.
   *
   * @method __construct
   * @param  Feature     $feature
   *
   * @return void
   */
  public function __construct(Characteristic $characteristic, Guard $auth)
  {
    $this->user   = $auth->user();

    // artisan route:list fail
    $this->userId = $auth->user() ? $auth->user()->id : null;

    $this->modelValidator = new ModelValidation($this->userId, $this->user);
    $this->characteristic = $characteristic;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
    $product = Product::findOrFail($id)->load('mechanical');

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if ($product->characteristics) {
      flash()->error('Este Producto ya posee caracteristicas, por favor actualice las existentes.');
      return redirect()->action('ProductsController@show', $product->slug);
    }

    return view('characteristic.create')->with([
      'product' => $product,
      'characteristic'    => $this->characteristic
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($id, CharacteristicRequest $request)
  {
    $product = Product::findOrFail($id)->load('mechanical');

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if ($product->characteristic) :
      flash()->error('Este Producto ya posee caracteristicas, por favor actualice las existentes.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    $this->characteristic = new Characteristic($request->all());
    $product->characteristics()->save($this->characteristic);

    flash('Caracteristicas del producto creadas exitosamente.');
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
    $this->characteristic = Characteristic::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->characteristic->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $this->characteristic->product->slug);
    endif;

    return view('characteristic.edit')->with(['characteristic' => $this->characteristic]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, CharacteristicRequest $request)
  {
    $this->characteristic = Characteristic::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->characteristic->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $this->characteristic->product->slug);
    endif;

    $this->characteristic->update($request->all());

    flash('Caracteristicas del Producto Actualizadas exitosamente.');
    return redirect()->action('ProductsController@show', $this->characteristic->product->slug);
  }

}
