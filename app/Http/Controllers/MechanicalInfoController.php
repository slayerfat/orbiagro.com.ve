<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests\MechanicalInfoRequest;
use App\Http\Controllers\Controller;
use App\Product;
use App\MechanicalInfo;

class MechanicalInfoController extends Controller
{

    /**
     * @var App\MechanicalInfo
     */
    protected $mech;

    /**
     * Create a new controller instance.
     *
     * @method __construct
     * @param  MechanicalInfo $mech
     *
     * @return void
     */
    public function __construct(MechanicalInfo $mech)
    {
        $this->middleware('auth');

        $this->mech = $mech;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int      $id
     * @param  Guard    $auth
     *
     * @return Response
     */
    public function create($id, Guard $auth)
    {
        $product = Product::findOrFail($id)->load('mechanical');

        if (!$auth->user()->isOwnerOrAdmin($product->user_id)) {
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
     * @param  int                   $id
     * @param  MechanicalInfoRequest $request
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
     * @param  int      $id
     * @param  Guard    $auth
     *
     * @return Response
     */
    public function edit($id, Guard $auth)
    {
        $this->mech = MechanicalInfo::findOrFail($id)->load('product');

        if (!$auth->user()->isOwnerOrAdmin($this->mech->product->user_id)) {
            return $this->redirectToRoute('productos.show', $this->mech->product->slug);
        }

        return view('mechanicalInfo.edit')->with(['mech' => $this->mech]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int                   $id
    * @param  MechanicalInfoRequest $request
    *
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
