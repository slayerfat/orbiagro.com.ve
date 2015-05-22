<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\MechanicalInfo;

use App\Mamarrachismo\ModelValidation;

class MechanicalInfoController extends Controller {

  private $user, $userId, $mech;

  /**
   * Create a new controller instance.
   *
   * @method __construct
   * @param  Feature     $feature
   *
   * @return void
   */
  public function __construct(MechanicalInfo $mech)
  {
    $this->middleware('auth');
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->modelValidator = new ModelValidation($this->userId, $this->user);
    $this->mech = $mech;
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
      return redirect()->action('ProductsController@show', $id);
    endif;

    if ($product->mechanical) {
      flash()->error('Este Producto ya posee informacion mecanica, por favor actualice el existente.');
      return redirect()->action('ProductsController@show', $id);
    }

    return view('mechanicalInfo.create')->with([
      'product' => $product,
      'mech'    => $this->mech
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($id, Request $request)
  {
    $product = Product::findOrFail($id)->load('mechanical');

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;

    if ($product->mechanical) {
      flash()->error('Este Producto ya posee informacion mecanica, por favor actualice el existente.');
      return redirect()->action('ProductsController@show', $id);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $mech = MechanicalInfo::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($mech->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $mech = MechanicalInfo::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($mech->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;
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

}
