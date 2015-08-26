<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use Orbiagro\Http\Requests\FeatureRequest;
use Orbiagro\Http\Controllers\Controller;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Orbiagro\Models\Product;
use Orbiagro\Models\Feature;

/**
 * Class FeaturesController
 * @package Orbiagro\Http\Controllers
 */
class FeaturesController extends Controller
{

    use CanSaveUploads;

    /**
     * @var \Orbiagro\Models\User
     */
    protected $user;

    /**
     * @var Feature
     */
    protected $feature;

    /**
     * Create a new controller instance.
     *
     * @param Feature $feature
     * @param Guard   $auth
     */
    public function __construct(Feature $feature, Guard $auth)
    {
        $this->middleware('auth');

        $this->user = $auth->user();

        $this->feature = $feature;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function create($id)
    {
        $product = Product::findOrFail($id)->load('features', 'user');

        if ($product->features->count() < 5) {
            if ($this->user->isOwnerOrAdmin($product->user->id)) {
                return view('feature.create')->with([
                    'product' => $product,
                    'feature' => $this->feature
                ]);
            }

            return $this->redirectToroute('products.show', $product->slug);
        }

        return $this->redirectToRoute(
            'products.show',
            $product->slug,
            'Este Producto ya posee 5 Distintivos, por favor actualice los existentes.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @method store
     * @param  int            $id
     * @param  FeatureRequest $request
     *
     * @return Response
     */
    public function store($id, FeatureRequest $request)
    {
        $product = Product::findOrFail($id);

        // el producto puede tener como maximo 5 features
        if ($product->features->count() >= 5) {
            return $this->redirectToRoute(
                'products.show',
                $product->slug,
                'Este Producto ya posee 5 Distintivos, por favor actualice los existentes.'
            );
        }

        $this->feature->title       = $request->input('title');
        $this->feature->description = $request->input('description');

        $product->features()->save($this->feature);

        /**
         * @see MakersController::create()
         */
        flash('Distintivo creado correctamente.');

        $this->createFile($request, $this->feature);

        $this->createImage($request, $this->feature);


        return redirect()->route('products.show', $product->slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->feature = Feature::findOrFail($id)->load('product', 'product.user');

        if (!$this->user->isOwnerOrAdmin($this->feature->product->user->id)) {
            return $this->redirectToroute('products.show', $this->feature->product->slug);
        }

        return view('feature.edit')->with(['feature' => $this->feature]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  FeatureRequest $request
     *
     * @return Response
     */
    public function update($id, FeatureRequest $request)
    {
        // se carga el producto para el redirect (id)
        $this->feature = Feature::findOrFail($id)->load('product', 'product.user');

        $this->feature->update($request->all());

        /**
         * @see MakersController::create()
         */
        flash('El Distintivo ha sido actualizado correctamente.');

        $this->updateFile($request, $this->feature);

        $this->updateImage($request, $this->feature);

        return redirect()->route('products.show', $this->feature->product->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->feature = Feature::findOrFail($id)->load('product', 'product.user');

        if (!$this->user->isOwnerOrAdmin($this->feature->product->user->id)) {
            return $this->redirectToroute('products.show', $this->feature->product->slug);
        }

        $this->feature->delete();

        return $this->redirectToRoute(
            'products.show',
            $this->feature->product->slug,
            'El Distintivo ha sido eliminado correctamente.',
            'info'
        );
    }
}
