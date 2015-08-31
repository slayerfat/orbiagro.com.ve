<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View\View as Response;
use Orbiagro\Repositories\Interfaces\ProductProviderRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;

class ProductsProvidersController extends Controller
{

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var ProductProviderRepositoryInterface
     */
    private $providerRepo;

    /**
     * Create a new controller instance.
     * @param ProductRepositoryInterface $productRepo
     * @param ProductProviderRepositoryInterface $providerRepo
     */
    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductProviderRepositoryInterface $providerRepo
    ) {
        $this->middleware('auth');

        $this->middleware('user.admin');

        $this->productRepo = $productRepo;
        $this->providerRepo = $providerRepo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int      $productId
     * @return Response
     */
    public function create($productId)
    {
        $product = $this->productRepo->getBySlugOrId($productId);

        $providers = $this->providerRepo->getLists();

        $provider = $this->providerRepo->getEmptyInstance();

        $providerId = null;

        $product->sku = null;

        return view('product.provider.create', compact(
            'product',
            'providers',
            'provider',
            'providerId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int     $productId
     * @param  Request $request
     * @return Response
     */
    public function store($productId, Request $request)
    {
        $this->validate($request, [
            'provider_id' => 'required|numeric'
        ]);

        $product = $this->productRepo->getBySlugOrId($productId);

        $product->providers()->attach(
            $request->input('provider_id'),
            ['sku' => $request->input('sku')]
        );

        flash()->success('El Proveedor fue asociado con exito.');
        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $productId
     * @param  int $providerId
     * @return Response
     */
    public function edit($productId, $providerId)
    {
        $product = $this->productRepo->getBySlugOrId($productId);

        $providers = $this->providerRepo->getLists();

        $provider  = $product->providers()->where('provider_id', $providerId)->first();

        $product->sku = $provider->pivot->sku;

        return view('product.provider.edit', compact('product', 'providers', 'providerId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $productId
     * @param  int $providerId
     * @param  Request $request
     *
     * @return Response
     */
    public function update($productId, $providerId, Request $request)
    {
        $this->validate($request, [
            'provider_id' => 'required|numeric'
        ]);

        $product = $this->productRepo->getBySlugOrId($productId);

        $product->providers()->updateExistingPivot(
            $providerId,
            [
                'sku' => $request->input('sku'),
                'provider_id' => $request->input('provider_id')
            ]
        );

        flash()->success('El Proveedor fue asociado con exito.');

        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $productId
     * @param  int $providerId
     * @return Response
     */
    public function destroy($productId, $providerId)
    {
        $product = $this->productRepo->getBySlugOrId($productId);

        $provider = $this->providerRepo->getById($providerId);

        $product->providers()->detach($provider);

        return response()->json(['success']);
    }
}
