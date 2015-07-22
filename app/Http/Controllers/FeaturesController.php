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

  private $user, $userId, $feature, $modelValidator;

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
    $product = Product::findOrFail($id)->load('features', 'user');

    if ($product->features->count() < 5) :
      if($this->modelValidator->notOwner($product->user->id)) :
        flash()->error('Ud. no tiene permisos para esta accion.');
        return redirect()->action('ProductsController@show', $product->slug);
      endif;
      return view('feature.create')->with([
        'product' => $product,
        'feature' => $this->feature
      ]);
    endif;

    flash()->error('Este Producto ya posee 5 features, por favor actualice los existentes.');
    return redirect()->action('ProductsController@show', $product->slug);
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

    // el producto puede tener como maximo 5 features
    if ($product->features->count() >= 5) :
      flash()->error('Este Producto ya posee 5 distintivos, por favor actualice los existentes.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    if($this->modelValidator->notOwner($product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
    endif;

    $this->feature->title       = $request->input('title');
    $this->feature->description = $request->input('description');
    $this->feature->created_by  = $this->userId;
    $this->feature->updated_by  = $this->userId;

    $product->features()->save($this->feature);

    flash('Distintivo creado correctamente.');

    // para guardar la imagen y modelo

    if ($request->hasFile('file'))
      try
      {
        $upload->createFile($request->file('file'), $this->feature);
      }
      catch (\Exception $e)
      {
        flash()->warning('Distintivo creado, pero el archivo no pudo ser procesado');
        return redirect()
          ->action('ProductsController@show', $product->slug)
          ->withErrors($upload->errors);
      }

    // TODO: mejorar?
    // para guardar la imagen y modelo
    if ($request->hasFile('image'))
      try
      {
        $upload->createImage($request->file('image'), $this->feature);
      }
      catch (\Exception $e)
      {
        flash()->warning('El Distintivo ha sido actualizado, pero la imagen asociada no pudo ser creada.');
        return redirect()
          ->action('ProductsController@show', $product->slug)
          ->withErrors($upload->errors);
      }

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
    $this->feature = Feature::findOrFail($id)->load('product');

    if($this->modelValidator->notOwner($this->feature->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

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
    // se carga el producto para el redirect (id)
    $this->feature = Feature::findOrFail($id)->load('product');

    // para dates
    $upload->userId = $this->userId;

    if($this->modelValidator->notOwner($this->feature->product->user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $product->slug);
    endif;

    $this->feature->updated_by = $this->userId;
    $this->feature->update($request->all());
    flash('El Distintivo ha sido actualizado correctamente.');

    // TODO: mejorar?
    // para guardar la imagen y modelo
    if ($request->hasFile('image'))
      try
      {
        $upload->updateImage($request->file('image'), $this->feature, $this->feature->image);
      }
      catch (\Exception $e)
      {
        flash()->warning('El Distintivo ha sido actualizado, pero la imagen asociada no pudo ser actualizada.');
        return redirect()
          ->action('ProductsController@show', $this->feature->product->slug)
          ->withErrors($upload->errors);
      }

    if ($request->hasFile('file'))
      try
      {
        $upload->updateFile($request->file('file'), $this->feature, $this->feature->file);
      }
      catch (\Exception $e)
      {
        flash()->warning('Distintivo actualizado, pero el archivo no pudo ser actualizado');
        return redirect()
          ->action('ProductsController@show', $this->feature->product->slug)
          ->withErrors($upload->errors);
      }

    return redirect()->action('ProductsController@show', $this->feature->product->slug);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $feature = Feature::findOrFail($id)->load('product');

    if(!$this->user->isOwnerOrAdmin($feature->product->user_id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $feature->product->slug);
    endif;

    $feature->delete();

    flash()->info('El Distintivo ha sido eliminado correctamente.');
    return redirect()->action('ProductsController@show', $feature->product->slug);
  }

}
