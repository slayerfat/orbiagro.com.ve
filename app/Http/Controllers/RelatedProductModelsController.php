<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\Controller;
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
