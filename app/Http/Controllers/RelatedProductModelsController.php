<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests\CharacteristicRequest;
use Orbiagro\Http\Requests\MechanicalInfoRequest;
use Orbiagro\Http\Requests\NutritionalRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\Guard;
use Orbiagro\Http\Requests\Request;
use Orbiagro\Models\Characteristic;
use Orbiagro\Models\MechanicalInfo;
use Orbiagro\Models\Nutritional;
use Illuminate\View\View;
use Orbiagro\Models\Product;

class RelatedProductModelsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @method __construct
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param  int $id
     * @param MechanicalInfo $mech
     * @param  Guard $auth
     * @return RedirectResponse
     */
    public function createMechInfo($id, MechanicalInfo $mech, Guard $auth)
    {
        return $this->createPrototype($id, $mech, $auth);
    }

    /**
     * @param  int         $id
     * @param  Nutritional $nuts  an instance of Deez Nuts.
     * @param  Guard       $auth
     *
     * @return RedirectResponse
     */
    public function createNutritional($id, Nutritional $nuts, Guard $auth)
    {
        return $this->createPrototype($id, $nuts, $auth);
    }

    /**
     * @param  int            $id
     * @param  Characteristic $char
     * @param  Guard          $auth
     *
     * @return RedirectResponse
     */
    public function createCharacteristic($id, Characteristic $char, Guard $auth)
    {
        return $this->createPrototype($id, $char, $auth);
    }

    /**
     * @param  int      $id
     * @param  Model    $model
     * @param  Guard    $auth
     *
     * @return RedirectResponse
     */
    protected function createPrototype($id, Model $model, Guard $auth)
    {
        $relation = $this->getRelatedMethod($model);

        $product  = Product::findOrFail($id)->load($relation);

        if (!$auth->user()->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToroute('products.show', $product->slug);
        }

        // para la vista
        $variables = [];

        $results   = $this->getViewVariables($model);

        if ($product->$relation) {
            return $this->redirectToRoute(
                'products.show',
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

        return view($results['target'].'create')->with($variables);
    }

    /**
     * @param  int                   $id
     * @param  Characteristic        $char
     * @param  CharacteristicRequest $request
     *
     * @return RedirectResponse
     */
    public function storeCharacteristic($id, Characteristic $char, CharacteristicRequest $request)
    {
        return $this->storePrototype($id, $char, $request);
    }

    /**
     * @param  int                   $id
     * @param  MechanicalInfo        $mech
     * @param  MechanicalInfoRequest $request
     *
     * @return RedirectResponse
     */
    public function storeMechInfo($id, MechanicalInfo $mech, MechanicalInfoRequest $request)
    {
        return $this->storePrototype($id, $mech, $request);
    }

    /**
     * @param  int                $id
     * @param  Nutritional        $nuts    Instance of DEEZ NUTS...
     * @param  NutritionalRequest $request
     *
     * @return RedirectResponse
     */
    public function storeNutritional($id, Nutritional $nuts, NutritionalRequest $request)
    {
        return $this->storePrototype($id, $nuts, $request);
    }

    /**
     * @param  int      $id
     * @param  Model    $model
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    protected function storePrototype($id, Model $model, Request $request)
    {
        $relation = $this->getRelatedMethod($model);

        $product = Product::findOrFail($id)->load($relation);

        if ($product->$relation) {
            return $this->redirectToRoute(
                'products.show',
                $product->slug,
                'Este Producto ya este recurso, por favor actualice.'
            );
        }

        $model->fill($request->all());

        $product->$relation()->save($model);

        flash('Recurso asociado creado exitosamente.');
        return redirect()->route('products.show', $product->slug);
    }

    /**
     * @param  int            $id
     * @param  Characteristic $char
     * @param  Guard          $auth
     *
     * @return View
     */
    public function editCharacteristic($id, Characteristic $char, Guard $auth)
    {
        return $this->editPrototype($id, $char, $auth);
    }

    /**
     * @param  int             $id
     * @param  MechanicalInfo  $mech
     * @param  Guard           $auth
     *
     * @return View
     */
    public function editMechInfo($id, MechanicalInfo $mech, Guard $auth)
    {
        return $this->editPrototype($id, $mech, $auth);
    }

    /**
     * @param  int         $id
     * @param  Nutritional $nuts Instance of DEEZ NUTS...
     * @param  Guard       $auth
     *
     * @return View
     */
    public function editNutritional($id, Nutritional $nuts, Guard $auth)
    {
        return $this->editPrototype($id, $nuts, $auth);
    }


    /**
     * @param  int   $id
     * @param  Model $model
     * @param  Guard $auth
     *
     * @return View
     */
    protected function editPrototype($id, Model $model, Guard $auth)
    {
        $model = $model::findOrFail($id)->load('product');

        if (!$auth->user()->isOwnerOrAdmin($model->product->user_id)) {
            return $this->redirectToroute('products.show', $model->product->slug);
        }

        $results = $this->getViewVariables($model);

        $variables = [];

        $variables[$results['variableName']] = $model;

        return view($results['target'].'edit')->with($variables);
    }

    /**
     * @param  int                   $id
     * @param  Characteristic        $char
     * @param  CharacteristicRequest $request
     *
     * @return RedirectResponse
     */
    public function updateCharacteristic($id, Characteristic $char, CharacteristicRequest $request)
    {
        return $this->updatePrototype($id, $char, $request);
    }

    /**
     * @param  int                   $id
     * @param  MechanicalInfo        $mech
     * @param  MechanicalInfoRequest $request
     *
     * @return RedirectResponse
     */
    public function updateMechInfo($id, MechanicalInfo $mech, MechanicalInfoRequest $request)
    {
        return $this->updatePrototype($id, $mech, $request);
    }

    /**
     * @param  int                $id
     * @param  Nutritional        $nuts Instance of DEEZ NUTS...
     * @param  NutritionalRequest $request
     *
     * @return RedirectResponse
     */
    public function updateNutritional($id, Nutritional $nuts, NutritionalRequest $request)
    {
        return $this->updatePrototype($id, $nuts, $request);
    }

    /**
     * @param  int     $id
     * @param  Model   $model
     * @param  Request $request
     *
     * @return RedirectResponse
     */
    public function updatePrototype($id, Model $model, Request $request)
    {
        $model = $model::findOrFail($id)->load('product');

        $model->update($request->all());

        flash('Recurso Actualizado exitosamente.');
        return redirect()->route('products.show', $model->product->slug);
    }

    /**
     * Regresa el nombre del metodo relacionado con el modelo.
     *
     * @param Model $model
     * @return string
     */
    protected function getRelatedMethod(Model $model)
    {
        switch (get_class($model)) {
            case MechanicalInfo::class:
                return 'mechanical';

            case Nutritional::class:
                return 'nutritional';

            case Characteristic::class:
                return 'characteristics';

            default:
                abort(500, 'No se encontro modelo relacionado');
        }
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     *
     * @param Model $model
     * @return array
     */
    protected function getViewVariables(Model $model)
    {
        switch (get_class($model)) {
            case MechanicalInfo::class:
                return [
                    'target'       => 'mechanicalInfo.',
                    'variableName' => 'mech',
                ];

            case Nutritional::class:
                return [
                    'target'       => 'nutritional.',
                    'variableName' => 'nutritional',
                ];

            case Characteristic::class:
                return [
                    'target'       => 'characteristic.',
                    'variableName' => 'characteristic',
                ];

            default:
                abort(500, 'No se pudieron generar variables');
        }
    }
}
