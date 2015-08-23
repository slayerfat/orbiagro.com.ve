<?php

namespace App\Http\Controllers;

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
    * @param  int      $id
    * @return Response
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @param  Upload  $upload
     *
     * @return Response
     */
    public function update(Request $request, $id, Upload $upload)
    {
        $upload->userId = Auth::id();

        $image = Image::with('imageable')->findOrFail($id);

        $data = $this->getControllerNameFromModel($image->imageable);

        flash()->success('Imagen Actualizada exitosamente.');

        if ($request->file('image')) {
            // se iteran las imagenes y se guardan los modelos
            $upload->updateImage($request->file('image'), $image);

            return redirect()->action($data['controller'], $data['id']);
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

        return redirect()->action($data['controller'], $data['id']);
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

    /**
    * Utilizado para generar el nombre del controlador y
    * el identificador necesario para encontrar el recurso.
    *
    * @param \Illuminate\Database\Eloquent\Model $model el modelo a manipular.
    *
    * @return array
    */
    protected function getControllerNameFromModel($model)
    {
        $array = ['controller' => '', 'id' => null];

        switch (get_class($model)) {
            case 'App\Product':
                $array['controller'] = 'ProductsController@show';
                break;

            case 'App\Feature':
                $array['controller'] = 'ProductsController@show';

                $array['id'] = $model->product->id;
                break;

            case 'App\Category':
                $array['controller'] = 'CategoriesController@show';
                break;

            case 'App\SubCategory':
                $array['controller'] = 'SubCategoriesController@show';
                break;

            case 'App\Maker':
                $array['controller'] = 'MakersController@show';
                break;

            case 'App\Promotion':
                $array['controller'] = 'PromotionsController@show';
                break;

            default:
                throw new \Exception("Error: modelo desconocido, no se puede crear ruta, modelo ".get_class($model), 2);

        }

        $array['id'] = $array['id'] ? $array['id'] : $model->slug;

        return $array;
    }
}
