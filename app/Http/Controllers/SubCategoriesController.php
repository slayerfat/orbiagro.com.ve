<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Illuminate\View\View as Response;
use Orbiagro\Mamarrachismo\VisitsService;
use Orbiagro\Http\Requests\SubCategoryRequest;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

class SubCategoriesController extends Controller
{

    use SEOToolsTrait, CanSaveUploads;

    /**
     * @var SubCategoryRepositoryInterface
     */
    private $subCatRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    private $catRepo;

    /**
     * @param SubCategoryRepositoryInterface $subCatRepo
     * @param CategoryRepositoryInterface $catRepo
     */
    public function __construct(
        SubCategoryRepositoryInterface $subCatRepo,
        CategoryRepositoryInterface $catRepo
    ) {
        $rules = ['except' => ['index', 'show', 'indexByCategory']];

        $this->middleware('auth', $rules);

        $this->middleware('user.admin', $rules);

        $this->subCatRepo = $subCatRepo;
        $this->catRepo    = $catRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subCats = $this->subCatRepo->getAll();

        $productsCollection = $this->getProductsInSubCat($subCats);

        $this->seo()->setTitle('Rubros en orbiagro.com.ve');
        $this->seo()->setDescription('Rubros en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('subCats.index'));

        return view('sub-category.index', compact('subCats', 'productsCollection'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int $id
     * @return Response
     */
    public function indexByCategory($id)
    {
        $subCats = $this->subCatRepo->getIndexByParent($id);

        $productsCollection = $this->getProductsInSubCat($subCats);

        $this->seo()->setTitle('Rubros en orbiagro.com.ve');
        $this->seo()->setDescription('Rubros en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('subCats.index'));

        return view('sub-category.index', compact('subCats', 'productsCollection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cats = $this->catRepo->getLists();

        $subCat = $this->subCatRepo->getEmptyInstance();

        return view('sub-category.create', compact('cats', 'subCat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubCategoryRequest $request
     * @return Response
     */
    public function store(SubCategoryRequest $request)
    {
        $cat = $this->catRepo->getById($request->input('category_id'));

        $subCat = $this->subCatRepo->getEmptyInstance();

        $subCat->fill($request->all());

        $cat->subCategories()->save($subCat);

        /**
         * @see MakersController::store()
         */
        flash()->success('Rubro creado exitosamente.');

        $this->createImage($request, $subCat);

        return redirect()->route('subCats.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  VisitsService $visits
     * @return Response
     */
    public function show($id, VisitsService $visits)
    {
        $subCat = $this->subCatRepo->getBySlugOrId($id);

        $subCats = $this->subCatRepo->getSibblings($subCat);

        $products = $this->subCatRepo->getProductsPaginated($subCat->id);

        $visits->setNewVisit($subCat);

        $this->seo()->setTitle("{$subCat->description} en orbiagro.com.ve")->setDescription(
            "{$subCat->description} en {$subCat->category->description} dentro de orbiagro.com.ve"
        );

        // $this->seo()->setKeywords(); taxonomias
        $this->seo()->opengraph()->setUrl(action('SubCategoriesController@show', $id));

        return view('sub-category.show', compact('products', 'subCat', 'subCats'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $subCat = $this->subCatRepo->getById($id);

        $cats = $this->catRepo->getLists();

        return view('sub-category.edit', compact('cats', 'subCat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                $id
     * @param  SubCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, SubCategoryRequest $request)
    {
        $subCat = $this->subCatRepo->getById($id);

        $subCat->fill($request->all());

        $subCat->update();

        /**
         * @see MakersController::store()
         */
        flash()->success('El Rubro ha sido actualizado correctamente.');

        $this->updateImage($request, $subCat);

        return redirect()->route('subCats.show', $subCat->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->subCatRepo->delete($id);

        return redirect()->action('SubCategoriesController@index');
    }

    /**
     * Busca aleatoriamente una cantidad de productos y regresa la coleccion.
     *
     * @param  \Illuminate\Support\Collection $subCats Las categorias.
     * @param  int                            $ammount La cantidad a tomar.
     * @return \Illuminate\Support\Collection
     */
    private function getProductsInSubCat($subCats, $ammount = 12)
    {
        $collection = collect();

        foreach ($subCats as $cat) {
            $collection->push($cat->products()->random()->take($ammount)->get());
        }

        return $collection;
    }
}
