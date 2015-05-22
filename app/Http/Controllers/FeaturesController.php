<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\FeatureRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Feature;

use App\Mamarrachismo\ModelValidation;
use App\Mamarrachismo\Upload;

class FeaturesController extends Controller {

  private $user, $userId, $feature;

  /**
   * Create a new controller instance.
   *
   * @method __construct
   * @param  Feature     $feature
   *
   * @return void
   */
  public function __construct(Feature $feature)
  {
    $this->middleware('auth');
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->modelValidator = new ModelValidation($this->userId, $this->user);
    $this->feature = $feature;
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
      return view('feature.create')->with([
        'product' => $product,
        'feature' => $this->feature
      ]);
    endif;

    flash()->error('Este Producto ya posee 5 features, por favor actualice los existentes.');
    return redirect()->action('ProductsController@show', $id);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @method store
   * @param  int            $id
   * @param  FeatureRequest $request
   * @param  Upload         $upload  clase para subir archivos.
   *
   * @return Response
   */
  public function store($id, FeatureRequest $request, Upload $upload)
  {
    $product = Product::findOrFail($id);
    // para los archivos del feature
    $upload->userId = $this->userId;

    if ($product->features->count() < 5) :
      if($this->modelValidator->notOwner($id)) :
        flash()->error('Ud. no tiene permisos para esta accion.');
        return redirect()->action('ProductsController@show', $id);
      endif;


      $this->feature->title       = $request->input('title');
      $this->feature->description = $request->input('description');
      $this->feature->created_by  = $this->userId;
      $this->feature->updated_by  = $this->userId;
      $product->features()->save($this->feature);

      // para guardar la imagen y modelo
      if ($request->hasFile('image')) :
        $upload->createFeatureImage($request->file('image'), $product, $this->feature);
      else:
        $upload->createDefaultFeatureImage($product, $this->feature);
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
    $this->feature = Feature::findOrFail($id);

    return view('feature.edit')->with(['feature' => $this->feature]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int            $id
   * @param  FeatureRequest $request
   * @param  Upload         $upload  clase para subir archivos.
   * @return Response
   */
  public function update($id, FeatureRequest $request, Upload $upload)
  {
    $this->feature = Feature::findOrFail($id)->load('product');

    $this->feature->update($request->all());
    flash('El feature ha sido actualizado correctamente.');
    // para guardar la imagen y modelo
    if ($request->hasFile('image')) :
      if (!$upload->updateFeatureImage($request->file('image'), $this->feature->product, $this->feature))
        flash()->error('La imagen no pudo ser actualizada correctamente');
    endif;

    return redirect()->action('ProductsController@show', $this->feature->product->id);
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
