<?php namespace Orbiagro\Http\Controllers;

use Illuminate\View\View as Response;
use Orbiagro\Http\Requests\CategoryRequest;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoriesController extends Controller
{

    use SEOToolsTrait, CanSaveUploads;

    /**
     * La instancia del repositorio
     *
     * @var CategoryRepositoryInterface
     */
    private $cat;

    /**
     * Create a new controller instance.
     *
     * @param CategoryRepositoryInterface $cat
     */
    public function __construct(CategoryRepositoryInterface $cat)
    {
        $options = ['except' => ['index', 'show']];

        $this->middleware('auth', $options);

        $this->middleware('user.admin', $options);

        $this->cat = $cat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cats  = $this->cat->getAll();

        $productsCollection = $this->cat->getRelatedProducts($cats);

        $this->seo()->setTitle('Categorias en orbiagro.com.ve');
        $this->seo()->setDescription('Categorias existentes es orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('cats.index'));

        return view('category.index', compact('cats', 'productsCollection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('category.create')->with([
            'cat' => $this->cat->getNewInstance()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest $request
     *
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        $cat = $this->cat->create($request->all());

        /**
         * @see MakersController::store()
         */
        flash()->success('Categoria creada exitosamente.');

        $this->createImage($request, $cat);

        return redirect()->route('cats.show', $cat->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $cat = $this->cat->getBySlugOrId($id);

        $subCats = $this->cat->getSubCats($cat);

        $this->seo()->setTitle("{$cat->description} en orbiagro.com.ve");
        $this->seo()->setDescription("{$cat->description} existentes es orbiagro.com.ve");
        $this->seo()->opengraph()->setUrl(route('cats.show', $id));

        return view('category.show', compact('cat', 'subCats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $cat = $this->cat->getById($id);

        return view('category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int             $id
     * @param  CategoryRequest $request
     *
     * @return Response
     */
    public function update($id, CategoryRequest $request)
    {
        $cat = $this->cat->update($id, $request->all());

        /**
         * @see MakersController::store()
         */
        flash()->success('La Categoria ha sido actualizada correctamente.');

        $this->updateImage($request, $cat);

        return redirect()->route('cats.show', $cat->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->cat->delete($id);

        flash()->success('La Categoria ha sido eliminada correctamente.');

        return redirect()->route('cats.index');
    }
}
