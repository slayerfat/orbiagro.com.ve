<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Provider;

class ProductsProvidersController extends Controller {

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($productId)
  {
    if(!$product = Product::with('user')->where('slug', $productId)->first())
      $product = Product::with('user')->findOrFail($productId);

    $providers = Provider::lists('name', 'id');

    $product->sku = null;

    return view('product.provider.create', compact('product', 'providers'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($productId, Request $request)
  {
    $this->validate($request, [
      'provider_id' => 'required|numeric'
    ]);

    if(!$product = Product::with('user')->where('slug', $productId)->first())
      $product = Product::with('user')->findOrFail($productId);

    $product->providers()->attach($request->input('provider_id'), ['sku' => $request->input('sku')]);

    flash()->success('El Proveedor fue asociado con exito.');
    return redirect()->action('ProductsController@show', $product->slug);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($productId, $providerId)
  {
    if(!$product = Product::with('user')->where('slug', $productId)->first())
      $product = Product::with('user')->findOrFail($productId);

    $provider = Provider::findOrFail($providerId);

    $product->providers()->detach($provider);

    return response()->json(['success']);
  }

}
