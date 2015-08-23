<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\CharacteristicRequest;
use App\Http\Requests\MechanicalInfoRequest;
use App\Http\Requests\NutritionalRequest;
use App\Characteristic;
use App\MechanicalInfo;
use App\Nutritional;
use App\Product;

class RelatedProductModelsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @method __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for MechanicalInfo.
     *
     * @param  int            $id
     * @param  MechanicalInfo $nuts
     * @param  Guard          $auth
     *
     * @return Response
     */
    public function createMechInfo($id, MechanicalInfo $mech, Guard $auth)
    {
        return $this->createPrototype($id, $mech, $auth);
    }

    /**
     * Show the form for Nutritional.
     *
     * @param  int      $id
     * @param  Nutritional $nuts  an instance of Deez Nuts.
     * @param  Guard       $auth
     *
     * @return Response
     */
    public function createNutritional($id, Nutritional $nuts, Guard $auth)
    {
        return $this->createPrototype($id, $nuts, $auth);
    }

    /**
     * Show the form for Nutritional.
     *
     * @param  int            $id
     * @param  Characteristic $char
     * @param  Guard          $auth
     *
     * @return Response
     */
    public function createCharacteristic($id, Characteristic $char, Guard $auth)
    {
        return $this->createPrototype($id, $char, $auth);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int      $id
     * @param  Model    $model
     * @param  Guard    $auth
     *
     * @return Response
     */
    protected function createPrototype($id, Model $model, Guard $auth)
    {
        $relation = $this->getRelationName($model);

        $product  = Product::findOrFail($id)->load($relation);

        if (!$auth->user()->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToRoute('productos.show', $product->slug);
        }

        // para la vista
        $variables = [];

        $relation  = $this->getChild($model);

        $results   = $this->getViewVariables($model);

        if ($product->$relation) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee este recurso.'
            );
        }

        $variables['product'] = $product;

        /**
         * el nombre que se le dara al modelo para
         * alguna vista en particular.
         * ej: 'mech => new MechanicalInfo',
         *
         * lo que implica:
         * $variables['mech'] (instancia de MechanicalInfo)
         */
        $variables[$results['variableName']] = $model;

        return view($results['target'])->with($variables);
    }

    /**
     * Show the form for Nutritional.
     *
     * @param  int                   $id
     * @param  Characteristic        $char
     * @param  CharacteristicRequest $request
     *
     * @return Response
     */
    public function storeCharacteristic($id, Characteristic $char, CharacteristicRequest $request)
    {
        return $this->storePrototype($id, $char, $request);
    }

    /**
     * Show the form for Nutritional.
     *
     * @param  int                   $id
     * @param  MechanicalInfo        $mech
     * @param  MechanicalInfoRequest $request
     *
     * @return Response
     */
    public function storeMechInfo($id, MechanicalInfo $mech, MechanicalInfoRequest $request)
    {
        return $this->storePrototype($id, $mech, $request);
    }

    /**
     * Show the form for Nutritional.
     *
     * @param  int                $id
     * @param  Nutritional        $nuts    Instance of DEEZ NUTS...
     * @param  NutritionalRequest $request
     *
     * @return Response
     */
    public function storeNutritional($id, Nutritional $nuts, NutritionalRequest $request)
    {
        return $this->storePrototype($id, $nuts, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int      $id
     * @param  Model    $model
     * @param  Request  $request
     *
     * @return Response
     */
    public function storePrototype($id, Model $model, Request $request)
    {
        $relation = $this->getRelationName($model);

        $product = Product::findOrFail($id)->load($relation);

        $relation = $this->getChild($model);

        if ($product->$relation) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya este recurso, por favor actualice.'
            );
        }

        $model->fill($request->all());

        $product->$relation()->save($model);

        flash('Recurso asociado creado exitosamente.');
        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
     * Regresa el hijo o relacion del modelo.
     *
     * @return string
     */
    protected function getRelationName(Model $model)
    {
        switch (class_basename($model)) {
            case 'MechanicalInfo':
            case 'Characteristic':
                return 'mechanical';

            case 'Nutritional':
                return 'nutritional';

            default:
                return abort(500);
        }
    }

    /**
     * Regresa el nombre del metodo relacionado con el modelo.
     *
     * @return string
     */
    protected function getChild(Model $model)
    {
        switch (class_basename($model)) {
            case 'MechanicalInfo':
            case 'Nutritional':
                return $this->getRelationName($model);

            case 'Characteristic':
                return 'characteristics';

            default:
                return abort(500);
        }
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     *
     * @return array
     */
    protected function getViewVariables(Model $model)
    {
        switch (class_basename($model)) {
            case 'MechanicalInfo':
                return [
                    'target'       => 'mechanicalInfo.create',
                    'variableName' => 'mech',
                ];

            case 'Nutritional':
                return [
                    'target'       => 'nutritional.create',
                    'variableName' => 'nutritional',
                ];

            case 'Characteristic':
                return [
                    'target'       => 'characteristic.create',
                    'variableName' => 'characteristic',
                ];

            default:
                return abort(500);
        }
    }
}
