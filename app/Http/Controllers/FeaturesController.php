<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Models\Product;
use Orbiagro\Models\Feature;
use Illuminate\View\View as Response;
use Illuminate\Http\RedirectResponse;
use Orbiagro\Http\Requests\FeatureRequest;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;
use Orbiagro\Repositories\Interfaces\FeatureRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;

class FeaturesController extends Controller
{

    use CanSaveUploads;

    /**
     * @var FeatureRepositoryInterface
     */
    protected $featRepo;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepo;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepo;

    /**
     * Create a new controller instance.
     *
     * @param FeatureRepositoryInterface $featureRepository
     * @param ProductRepositoryInterface $productRepository
     * @param UserRepositoryInterface    $userRepository
     */
    public function __construct(
        FeatureRepositoryInterface $featureRepository,
        ProductRepositoryInterface $productRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->middleware('auth');

        $this->featRepo = $featureRepository;
        $this->productRepo = $productRepository;
        $this->userRepo = $userRepository;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int    $id
     * @param Feature $feature
     *
     * @return RedirectResponse|Response
     */
    public function create($id, Feature $feature)
    {
        $product = $this->productRepo->getById($id);

        if ($this->featRepo->validateCreateRequest($id)) {
            return view('feature.create')->with([
                'product' => $product,
                'feature' => $feature
            ]);
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
     * @return RedirectResponse
     */
    public function store($id, FeatureRequest $request)
    {
        /** @var Product $product */
        $product = $this->productRepo->getById($id);

        // el producto puede tener como maximo 5 features
        if (!$this->featRepo->validateCreateRequest($id)) {
            return $this->redirectToRoute(
                'products.show',
                $product->slug,
                'Este Producto ya posee 5 Distintivos, actualice los existentes.'
            );
        }

        $feature = $this->featRepo->create($request->all(), $product);

        /**
         * @see MakersController::create()
         */
        flash('Distintivo creado correctamente.');

        $this->createFile($request, $feature);

        $this->createImage($request, $feature);

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
        $feature = $this->featRepo->getById($id);

        $feature->load('product', 'product.user');

        $status = $this->userRepo
            ->canUserManipulate($feature->product->user_id);

        if (!$status) {
            return $this->redirectToroute(
                'products.show',
                $feature->product->slug
            );
        }

        return view('feature.edit', compact('feature'));
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
        $feature = $this->featRepo->update($id, $request->all());

        /**
         * @see MakersController::create()
         */
        flash('El Distintivo ha sido actualizado correctamente.');

        $this->updateFile($request, $feature);

        $this->updateImage($request, $feature);

        return redirect()->route('products.show', $feature->product->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $feature = $this->featRepo->delete($id);

        return $this->redirectToRoute(
            'products.show',
            $feature->product->slug,
            'El Distintivo ha sido eliminado correctamente.',
            'info'
        );
    }
}
