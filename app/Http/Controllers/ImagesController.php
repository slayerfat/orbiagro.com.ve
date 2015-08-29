<?php namespace Orbiagro\Http\Controllers;

use Exception;
use Orbiagro\Models\Image;
use Orbiagro\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View\View as Response;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Repositories\Interfaces\ImageRepositoryInterface;

class ImagesController extends Controller
{

    /**
     * @var ImageRepositoryInterface
     */
    private $imageRepo;

    /**
     * Create a new controller instance.
     * @param ImageRepositoryInterface $imageRepo
     */
    public function __construct(ImageRepositoryInterface $imageRepo)
    {
        $this->middleware('user.admin');

        $this->imageRepo = $imageRepo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $image = $this->imageRepo->getById($id);

        return view('images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     * @param  int $id
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $image = $this->imageRepo->update($id, $request);

        /** @var Model $model */
        $model = $image->imageable;

        $data = $this->getControllerNameFromModel($model);

        flash()->success('Imagen Actualizada exitosamente.');

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
                throw new Exception('modelo desconocido, no se puede crear ruta de '.get_class($model));

        }

        $array['id'] = $array['id'] ? $array['id'] : $model->slug;

        return $array;
    }
}
