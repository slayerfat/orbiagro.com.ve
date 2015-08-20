<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests\CharacteristicRequest;
use App\Http\Controllers\Controller;

use App\Product;
use App\Characteristic;

use App\Mamarrachismo\ModelValidation;

class CharacteristicsController extends Controller
{
    private $characteristic;

    /**
    * Create a new controller instance.
    *
    * @method __construct
    * @param  Characteristic     $characteristic
    *
    * @return void
    */
    public function __construct(Characteristic $characteristic, Guard $auth)
    {
        $this->middleware('auth');

        $this->user = $auth->user();

        $this->characteristic = $characteristic;
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create($id)
    {
        $product = Product::findOrFail($id)->load('mechanical');

        if (!$this->user->isOwnerOrAdmin($product->user->id)) {
            return $this->redirectToRoute('productos.show', $product->slug);
        }

        if ($product->characteristics) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee caracteristicas, por favor actualice las existentes.'
            );
        }

        return view('characteristic.create')->with([
            'product'        => $product,
            'characteristic' => $this->characteristic
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store($id, CharacteristicRequest $request)
    {
        $product = Product::findOrFail($id)->load('mechanical');

        if ($product->characteristics) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee caracteristicas, por favor actualice las existentes.'
            );
        }

        $this->characteristic = new Characteristic($request->all());
        $product->characteristics()->save($this->characteristic);

        flash('Caracteristicas del producto creadas exitosamente.');
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
        $this->characteristic = Characteristic::findOrFail($id)->load('product');

        if (!$this->user->isOwnerOrAdmin($product->user->id)) {
            return $this->redirectToRoute('productos.show', $product->slug);
        }

        return view('characteristic.edit')->with(['characteristic' => $this->characteristic]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id, CharacteristicRequest $request)
    {
        $this->characteristic = Characteristic::findOrFail($id)->load('product');

        $this->characteristic->update($request->all());

        flash('Caracteristicas del Producto Actualizadas exitosamente.');
        return redirect()->action('ProductsController@show', $this->characteristic->product->slug);
    }
}
