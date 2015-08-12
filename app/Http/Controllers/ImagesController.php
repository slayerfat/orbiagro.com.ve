<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Intervention;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mamarrachismo\Upload\Image as Upload;

use App\Image;

class ImagesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('user.admin');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $image = Image::findOrFail($id);

    return view('images.edit', compact('image'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id, Upload $upload)
  {
    $upload->userId = Auth::id();

    $image = Image::with('imageable')->findOrFail($id);

    $controller = $this->getControllerNameFromModel($image->imageable);

    flash()->success('Imagen Actualizada exitosamente.');

    if ($request->file('image'))
    {
      // se iteran las imagenes y se guardan los modelos
      $upload->updateImage($request->file('image'), $image);

      return redirect()->action("{$controller}@show", $image->imageable->slug);
    }

    // http://image.intervention.io/api/crop
    // se ajusta segun estos valores:
    $upload->cropImage(
      $image,
      $request->input('dataWidth'),
      $request->input('dataHeight'),
      $request->input('dataX'),
      $request->input('dataY')
    );

    return redirect()->action("{$controller}@show", $image->imageable->slug);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $image = Image::with('imageable')->findOrFail($id);

    $product = $image->imageable;

    flash()->success('Imagen Eliminada exitosamente.');
    return redirect()->action('ProductsController@show', $product->id);
  }

  protected function getControllerNameFromModel($model)
  {
    switch (get_class($model)) :

      case 'App\Product':
        return 'ProductsController';

      case 'App\Feature':
        return 'FeaturesController';

      case 'App\Category':
        return 'CategoriesController';

      case 'App\SubCategory':
        return 'SubCategoriesController';

      case 'App\Maker':
        return 'MakersController';

      case 'App\Promotion':
        return 'PromotionsController';

      default:
        throw new Exception("Error: modelo desconocido, no se puede crear ruta, modelo ".gettype($model), 2);

    endswitch;
  }
}
