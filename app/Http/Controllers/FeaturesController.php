<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests\FeatureRequest;
use App\Http\Controllers\Controller;
use App\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use App\Product;
use App\Feature;

class FeaturesController extends Controller
{

    use CanSaveUploads;

    /**
     * @var \App\User
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
     *
     * @return void
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

            return $this->redirectToRoute('productos.show', $product->slug);
        }

        return $this->redirectToRoute(
            'productos.show',
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
                'productos.show',
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


        return redirect()->route('productos.show', $product->slug);
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
            return $this->redirectToRoute('productos.show', $this->feature->product->slug);
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

        return redirect()->route('productos.show', $this->feature->product->slug);
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
            return $this->redirectToRoute('productos.show', $this->feature->product->slug);
        }

        $this->feature->delete();

        return $this->redirectToRoute(
            'productos.show',
            $this->feature->product->slug,
            'El Distintivo ha sido eliminado correctamente.',
            'info'
        );
    }
}
