<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\MechanicalInfoRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\MechanicalInfo;

use App\Mamarrachismo\ModelValidation;

class MechanicalInfoController extends Controller
{

    private $user;

    private $mech;

    /**
    * Create a new controller instance.
    *
    * @method __construct
    * @param  Feature     $feature
    *
    * @return void
    */
    public function __construct(MechanicalInfo $mech)
    {
        $this->user   = Auth::user();

        $this->mech = $mech;
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create($id)
    {
        $product = Product::findOrFail($id)->load('mechanical');

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToRoute('productos.show', $product->slug);
        }

        if ($product->mechanical) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee Información Mecanica.'
            );
        }

        return view('mechanicalInfo.create')->with([
            'product' => $product,
            'mech'    => $this->mech
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store($id, MechanicalInfoRequest $request)
    {
        $product = Product::findOrFail($id)->load('mechanical');

        if ($product->mechanical) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee Información Mecanica.'
            );
        }

        $this->mech = new MechanicalInfo($request->all());

        $product->mechanical()->save($this->mech);

        flash('Información Mecanica creada exitosamente.');

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
        $this->mech = MechanicalInfo::findOrFail($id)->load('product');

        if (!$this->user->isOwnerOrAdmin($this->mech->product->user_id)) {
            return $this->redirectToRoute('productos.show', $this->mech->product->slug);
        }

        return view('mechanicalInfo.edit')->with(['mech' => $this->mech]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id, MechanicalInfoRequest $request)
    {
        $this->mech = MechanicalInfo::findOrFail($id)->load('product');

        $this->mech->update($request->all());

        flash('Información Mecanica Actualizada exitosamente.');

        return redirect()->action('ProductsController@show', $this->mech->product->slug);
    }
}
