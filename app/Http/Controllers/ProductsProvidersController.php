<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Illuminate\Http\Request;
use Orbiagro\Http\Controllers\Controller;
use Orbiagro\Models\Product;
use Orbiagro\Models\Provider;
use Illuminate\View\View as Response;

class ProductsProvidersController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('user.admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int      $productId
     * @return Response
     */
    public function create($productId)
    {
        if (!$product = Product::where('slug', $productId)->first()) {
            $product = Product::findOrFail($productId);
        }

        $providers = Provider::lists('name', 'id');

        $provider = new Provider;
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

        if (!$product = Product::with('user')->where('slug', $productId)->first()) {
            $product = Product::with('user')->findOrFail($productId);
        }

        $product->providers()->attach($request->input('provider_id'), ['sku' => $request->input('sku')]);

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
        if (!$product = Product::where('slug', $productId)->first()) {
            $product = Product::findOrFail($productId);
        }

        $providers = Provider::lists('name', 'id');
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

        if (!$product = Product::where('slug', $productId)->first()) {
            $product = Product::findOrFail($productId);
        }

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
        if (!$product = Product::where('slug', $productId)->first()) {
            $product = Product::findOrFail($productId);
        }

        $provider = Provider::findOrFail($providerId);

        $product->providers()->detach($provider);

        return response()->json(['success']);
    }
}
