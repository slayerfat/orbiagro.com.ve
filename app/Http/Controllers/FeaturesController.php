<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Feature;

use App\Mamarrachismo\ModelValidation;
use App\Mamarrachismo\Upload;

class FeaturesController extends Controller {

  private $user, $userId;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->modelValidator = new ModelValidation($this->userId, $this->user);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
    $product = Product::findOrFail($id)->load('features');

    if ($product->features->count() < 5) :
      if($this->modelValidator->notOwner($id)) :
        flash()->error('Ud. no tiene permisos para esta accion.');
        return redirect()->action('ProductsController@show', $id);
      endif;

      return view('feature.create', compact('product'));
    endif;

    flash()->error('Este Producto ya posee 5 features, por favor actualice los existentes.');
    return redirect()->action('ProductsController@show', $id);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($id, Request $request, Upload $upload)
  {
    $product = Product::findOrFail($id);
    // para los archivos del feature
    $upload->userId = $this->userId;

    if ($product->features->count() < 5) :
      if($this->modelValidator->notOwner($id)) :
        flash()->error('Ud. no tiene permisos para esta accion.');
        return redirect()->action('ProductsController@show', $id);
      endif;

      $feature = new Feature($request->all());
      $feature->created_by = $this->userId;
      $feature->updated_by = $this->userId;
      $product->features()->save($feature);

      // para guardar la imagen y modelo
      if ($request->hasFile('image')) :
        $upload->createFeatureImage($request->file('image'), $product, $feature);
      else:
        $upload->createDefaultFeatureImage($product, $feature);
      endif;

      flash('Producto actualizado correctamente.');
      return redirect()->action('ProductsController@show', $product->id);
    endif;

    flash()->error('Este Producto ya posee 5 features, por favor actualice los existentes.');
    return redirect()->action('ProductsController@show', $id);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
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
