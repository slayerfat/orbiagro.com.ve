<?php namespace Orbiagro\Http\Controllers;

use Illuminate\View\View as Response;
use Orbiagro\Http\Requests\MakerRequest;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Orbiagro\Repositories\Interfaces\MakerRepositoryInterface;

class MakersController extends Controller
{

    use SEOToolsTrait, CanSaveUploads;

    /**
     * @var MakerRepositoryInterface
     */
    private $makerRepo;

    /**
     * Create a new controller instance.
     * @param MakerRepositoryInterface $makerRepo
     */
    public function __construct(MakerRepositoryInterface $makerRepo)
    {
        $rules = ['except' => ['show']];

        $this->middleware('auth', $rules);
        $this->middleware('user.admin', $rules);

        $this->makerRepo = $makerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $makers = $this->makerRepo->getAll();

        $this->seo()->setTitle('Fabricantes en orbiagro.com.ve');
        $this->seo()->setDescription('Fabricantes existentes en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('makers.index'));

        return view('maker.index', compact('makers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $maker = $this->makerRepo->getEmptyInstance();

        return view('maker.create', compact('maker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MakerRequest $request
     *
     * @return Response
     */
    public function store(MakerRequest $request)
    {
        $maker = $this->makerRepo->create($request->all());

        /**
         * se flashea antes de crear la imagen para que los
         * errores (si ocurren) de la creacion de imagen
         * no sean descartados por este flash.
         */
        flash()->success('Fabricante creado exitosamente.');

        $this->createImage($request, $maker);

        return redirect()->action('MakersController@show', $maker->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $maker = $this->makerRepo->getBySlugOrId($id);

        $this->seo()->setTitle("{$maker->name} y sus articulos en orbiagro.com.ve");
        $this->seo()->setDescription("{$maker->name} y sus productos relacionados en orbiagro.com.ve");
        $this->seo()->opengraph()->setUrl(action('MakersController@show', $id));

        return view('maker.show', compact('maker'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $maker = $this->makerRepo->getBySlugOrId($id);

        return view('maker.edit', compact('maker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  MakerRequest $request
     *
     * @return Response
     */
    public function update($id, MakerRequest $request)
    {
        $maker = $this->makerRepo->update($id, $request->all());

        /**
         * @see self::create()
         */
        flash()->success('Fabricante Actualizado exitosamente.');

        $this->updateImage($request, $maker);

        return redirect()->action('MakersController@show', $maker->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->makerRepo->delete($id);

        return redirect()->action('MakersController@index');
    }
}
