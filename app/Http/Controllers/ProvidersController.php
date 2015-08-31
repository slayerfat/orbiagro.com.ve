<?php namespace Orbiagro\Http\Controllers;

use Illuminate\View\View as Response;
use Orbiagro\Http\Requests\ProviderRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Orbiagro\Repositories\Interfaces\ProductProviderRepositoryInterface;

class ProvidersController extends Controller
{

    /**
     * @var ProductProviderRepositoryInterface
     */
    private $providerRepo;

    /**
     * Create a new controller instance.
     * @param ProductProviderRepositoryInterface $providerRepo
     */
    public function __construct(ProductProviderRepositoryInterface $providerRepo)
    {
        $this->middleware('user.admin');
        $this->providerRepo = $providerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $providers = $this->providerRepo->getAll();

        return view('provider.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $provider = $this->providerRepo->getEmptyInstance();

        return view('provider.create', compact('provider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProviderRequest $request
     * @return RedirectResponse
     */
    public function store(ProviderRequest $request)
    {
        $provider = $this->providerRepo->store($request->all());

        flash()->success('Proveedor creado exitosamente.');

        return redirect()->route('providers.show', $provider->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $provider = $this->providerRepo->getById($id);

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
        $provider = $this->providerRepo->getById($id);

        return view('provider.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  ProviderRequest $request
     *
     * @return RedirectResponse
     */
    public function update($id, ProviderRequest $request)
    {
        $provider = $this->providerRepo->update($id, $request->all());

        flash()->success('Proveedor actualizado exitosamente.');

        return redirect()->route('providers.show', $provider->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        if (!$this->providerRepo->destroy($id)) {
            return $this->redirectToRoute(
                'providers.show',
                $id,
                'No deben haber elementos asociados.'
            );
        }
        flash()->success('El Proveedor ha sido eliminado correctamente.');

        return redirect()->route('providers.index');
    }
}
