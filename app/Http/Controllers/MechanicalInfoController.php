<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\MechanicalInfoRequest;
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
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if ($product->mechanical) {
      flash()->error('Este Producto ya posee informacion mecanica, por favor actualice el existente.');
      return redirect()->action('ProductsController@show', $product->slug);
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
  public function store($id, MechanicalInfoRequest $request)
  {
    $product = Product::findOrFail($id)->load('mechanical');

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if ($product->mechanical) :
      flash()->error('Este Producto ya posee informacion mecanica, por favor actualice el existente.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    $this->mech = new MechanicalInfo($request->all());
    $this->mech->created_by = $this->userId;
    $this->mech->updated_by = $this->userId;

    $product->mechanical()->save($this->mech);

    flash('Información Mecanica creada exitosamente.');
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
    $this->mech = MechanicalInfo::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->mech->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $this->mech->product->slug);
    endif;

    return view('mechanicalInfo.edit')->with(['mech' => $this->mech]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, MechanicalInfoRequest $request)
  {
    $this->mech = MechanicalInfo::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->mech->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $this->mech->product->slug);
    endif;

    $this->mech->updated_by = $this->userId;
    $this->mech->update($request->all());

    flash('Información Mecanica Actualizada exitosamente.');
    return redirect()->action('ProductsController@show', $this->mech->product->slug);
  }

}
