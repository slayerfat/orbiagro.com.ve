<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests\ProviderRequest;
use Orbiagro\Http\Controllers\Controller;
use Illuminate\View\View as Response;
use Orbiagro\Models\Provider;

class ProvidersController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('user.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $providers = Provider::with('products')->get();

        return view('provider.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $provider = new Provider;

        return view('provider.create', compact('provider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProviderRequest $request
     * @return Response
     */
    public function store(ProviderRequest $request)
    {
        $provider = new Provider($request->all());

        $provider->save();

        flash()->success('Proveedor creado exitosamente.');

        return redirect()->action('ProvidersController@show', $provider->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $provider = Provider::with('products')->findOrFail($id);

        return view('provider.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $provider = Provider::findOrFail($id);

        return view('provider.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  ProviderRequest $request
     *
     * @return Response
     */
    public function update($id, ProviderRequest $request)
    {
        $provider = Provider::findOrFail($id);

        $provider->update($request->all());

        flash()->success('Proveedor actualizado exitosamente.');

        return redirect()->action('ProvidersController@show', $provider->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);

        try {
            $provider->delete();
        } catch (\Exception $e) {
            if ($e instanceof \QueryException || (int)$e->errorInfo[0] == 23000) {
                return $this->redirectToRoute(
                    'proveedores.show',
                    $id,
                    'No deben haber elementos asociados.'
                );
            }
            \Log::error($e);

            abort(500);
        }

        flash()->success('El Proveedor ha sido eliminado correctamente.');

        return redirect()->action('ProvidersController@index');
    }
}
