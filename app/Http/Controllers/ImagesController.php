<?php namespace Orbiagro\Http\Controllers;

use Auth;
use Exception;
use Orbiagro\Models\Image;
use Intervention;
use Orbiagro\Http\Requests;
use Illuminate\Http\Request;
use Orbiagro\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;

/**
 * Class ImagesController
 * @package Orbiagro\Http\Controllers
 */
class ImagesController extends Controller
{

    /**
     * Create a new controller instance.
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
     * @param  int     $id
     * @param  Request $request
     * @param  Upload  $upload
     *
     * @return Response
     */
    public function update($id, Request $request, Upload $upload)
    {
        $upload->userId = Auth::id();

        $image = Image::with('imageable')->findOrFail($id);

        $data = $this->getControllerNameFromModel($image->imageable);

        flash()->success('Imagen Actualizada exitosamente.');

        if ($request->file('image')) {
            $upload->update($image, $request->file('image'));

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
     * @param  Model $model el modelo a manipular.
     * @return array
     * @throws Exception
     */
    protected function getControllerNameFromModel(Model $model)
    {
        $array = ['controller' => '', 'id' => null];

        switch (get_class($model)) {
            case 'Orbiagro\Models\Product':
                $array['controller'] = 'ProductsController@show';
                break;

            case 'Orbiagro\Models\Feature':
                $array['controller'] = 'ProductsController@show';

                $array['id'] = $model->product->id;
                break;

            case 'Orbiagro\Models\Category':
                $array['controller'] = 'CategoriesController@show';
                break;

            case 'Orbiagro\Models\SubCategory':
                $array['controller'] = 'SubCategoriesController@show';
                break;

            case 'Orbiagro\Models\Maker':
                $array['controller'] = 'MakersController@show';
                break;

            case 'Orbiagro\Models\Promotion':
                $array['controller'] = 'PromotionsController@show';
                break;

            default:
                throw new Exception('modelo desconocido, no se puede crear ruta ', modelo.get_class($model));

        }

        $array['id'] = $array['id'] ? $array['id'] : $model->slug;

        return $array;
    }
}
