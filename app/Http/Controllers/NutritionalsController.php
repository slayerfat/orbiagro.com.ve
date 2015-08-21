<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\NutritionalRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Nutritional;

use App\Mamarrachismo\ModelValidation;

class NutritionalsController extends Controller
{

    protected $user;

    protected $nutritional;

    /**
    * Create a new controller instance.
    *
    * @method __construct
    * @param  Feature     $feature
    *
    * @return void
    */
    public function __construct(Nutritional $nutritional)
    {
        $this->user   = Auth::user();

        $this->nutritional = $nutritional;
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create($id)
    {
        $product = Product::findOrFail($id)->load('nutritional');

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToRoute('productos.show', $product->slug);
        }

        if ($product->nutritional) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee Valores Nutricionales.'
            );
        }

        return view('nutritional.create')->with([
            'product'     => $product,
            'nutritional' => $this->nutritional
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store($id, NutritionalRequest $request)
    {
        $product = Product::findOrFail($id)->load('nutritional');

        if ($product->nutritional) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee Valores Nutricionales.'
            );
        }

        $this->nutritional = new Nutritional($request->all());

        $product->nutritional()->save($this->nutritional);

        flash('Valores Nutricionales del producto creados exitosamente.');

        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $this->nutritional = Nutritional::findOrFail($id)->load('product');

        if (!$this->user->isOwnerOrAdmin($this->nutritional->product->user_id)) {
            return $this->redirectToRoute('productos.show', $this->nutritional->product->slug);
        }

        return view('nutritional.edit')->with(['nutritional' => $this->nutritional]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id, NutritionalRequest $request)
    {
        $this->nutritional = Nutritional::findOrFail($id)->load('product');

        $this->nutritional->update($request->all());

        flash('Valores Nutricionales del Producto Actualizados exitosamente.');

        return redirect()->action('ProductsController@show', $this->nutritional->product->slug);
    }
}
