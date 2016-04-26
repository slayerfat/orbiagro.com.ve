<?php namespace Orbiagro\Http\Controllers;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Orbiagro\Http\Requests\CategoryRequest;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
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
     * @return View
     */
    public function index()
    {
        $cats  = $this->cat->getAll();
        $paths = $this->makeOpenGraphImages($cats);

        $productsCollection = $this->cat->getRelatedProducts($cats);

        $this->seo()->setTitle('Categorías en orbiagro.com.ve');
        $this->seo()->setDescription('Categorías existentes es orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('cats.index'));
        $this->seo()->opengraph()->addImages($paths);
        $this->seo()->twitter()->addImage(asset($cats->random()->image->small));

        return view('category.index', compact('cats', 'productsCollection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return view
     */
    public function create()
    {
        return view('category.create')->with([
            'cat' => $this->cat->getEmptyInstance(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest $request
     *
     * @return RedirectResponse
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
     * @param  int $id
     * @return View
     */
    public function show($id)
    {
        $cat     = $this->cat->getBySlugOrId($id);
        $subCats = $this->cat->getSubCats($cat);

        $this->seo()->setTitle("{$cat->description} en orbiagro.com.ve");
        $this->seo()->setDescription("{$cat->description} existentes es orbiagro.com.ve");
        $this->seo()->opengraph()->setUrl(route('cats.show', $id));
        $this->seo()->opengraph()->addImage(asset($cat->image->small));
        $this->seo()->twitter()->addImage(asset($cat->image->small));

        return view('category.show', compact('cat', 'subCats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
        $cat = $this->cat->getById($id);

        return view('category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  CategoryRequest $request
     *
     * @return RedirectResponse
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
     * @param  int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $deleted = $this->cat->delete($id);

        if ($deleted === true) {
            return redirect()->route('cats.index');
        }

        return redirect()->route('cats.show', $deleted->slug);
    }
}
