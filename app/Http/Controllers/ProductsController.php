<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Models\Maker;
use Illuminate\Http\Request;
use Orbiagro\Models\Product;
use Illuminate\View\View as Response;
use Orbiagro\Mamarrachismo\VisitsService;
use Orbiagro\Http\Requests\ProductRequest;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

class ProductsController extends Controller
{

    use SEOToolsTrait, CanSaveUploads;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    private $catRepo;

    /**
     * @var SubCategoryRepositoryInterface
     */
    private $subCatRepo;

    /**
     * Create a new controller instance.
     * @param ProductRepositoryInterface $productRepo
     * @param CategoryRepositoryInterface $catRepo
     * @param SubCategoryRepositoryInterface $subCatRepo
     */
    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $catRepo,
        SubCategoryRepositoryInterface $subCatRepo
    ) {
        $rules = ['except' =>
            [
                'index',
                'show',
                'indexByCategory',
                'indexBySubCategory'
            ]
        ];

        $this->middleware('auth', $rules);
        $this->middleware('user.unverified', $rules);

        $this->catRepo     = $catRepo;
        $this->subCatRepo  = $subCatRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  VisitsService $visits
     * @return Response
     */
    public function index(VisitsService $visits)
    {
        $products = $this->productRepo->getPaginated(20);
        $cats     = $this->catRepo->getAll();
        $subCats  = $this->subCatRepo->getAll();

        $visitedProducts = $visits->getVisitedResources(Product::class);

        $this->seo()->setTitle('Productos en orbiagro.com.ve');
        $this->seo()->setDescription('Productos y Articulos en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('products.index'));

        return view('product.index', compact(
            'products',
            'cats',
            'subCats',
            'visitedProducts'
        ));
    }

    /**
     * Muestra el index segun el Categoria.
     *
     * @param  int           $categoryId
     * @param  VisitsService $visits
     *
     * @return Response
     */
    public function indexByCategory($categoryId, VisitsService $visits)
    {
        return $this->indexByParent('category', $categoryId, $visits);
    }

    /**
     * Muestra el index segun el Rubro.
     *
     * @param  int           $subCategoryId
     * @param  VisitsService $visits
     *
     * @return Response
     */
    public function indexBySubCategory($subCategoryId, VisitsService $visits)
    {
        return $this->indexByParent('subCategory', $subCategoryId, $visits);
    }

    /**
     * Muestra el index segun la Categoria, Rubro, etc.
     *
     * @param  string         $parent
     * @param  int           $parentId
     * @param  VisitsService $visits
     *
     * @return Response
     */
    private function indexByParent($parent, $parentId, VisitsService $visits)
    {
        $products = $this->productRepo->getByParentSlugOrId($parent, $parentId);

        $visitedProducts = $visits->getVisitedResources(Product::class);

        $cats = $this->catRepo->getAll();

        $description = '';

        if ($parent == 'category') {
            $cat = $this->catRepo->getBySlugOrId($parentId);

            $subCats = $cat->subCategories;

            $description = $cat->description;
        } elseif ($parent == 'subCategory') {
            $subCats     = $this->subCatRepo->getAll();

            $description = $products->first()->subCategory->description;
        }

        $this->seo()->setTitle(
            'Productos de '
            .$description
            .' en orbiagro.com.ve'
        )->setDescription(
            'Productos y Articulos de '
            .$description
            .' en existencia en orbiagro.com.ve'
        );

        return view('product.index', compact(
            'products',
            'cats',
            'subCats',
            'visitedProducts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ($this->productRepo->isCurrentUserDisabled()) {
            flash()->error('Ud. no tiene permisos para esta accion.');

            return redirect()->back();
        }

        // TODO repo
        $makers = Maker::lists('name', 'id');

        $product = $this->productRepo->getEmptyInstance();

        $cats = $this->catRepo->getArraySortedWithSubCategories();

        return view('product.create', compact('product', 'makers', 'cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productRepo->store($request->all());
        flash()->success('El Producto ha sido creado con exito.');

        // se iteran las imagenes y se guardan los modelos
        $this->createImages($request, $product);

        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int           $id
     * @param  VisitsService $visits
     * @return Response
     */
    public function show($id, VisitsService $visits)
    {
        $product = $this->productRepo->getBySlugOrId($id);

        $visits->setNewVisit($product);

        $visitedProducts = $visits->getVisitedResources(Product::class);

        $isUserValid = $this->productRepo->canUserManipulate($product->user_id);

        $this->seo()->setTitle(
            "{$product->title} - {$product->priceBs()}"
        )->setDescription(
            $product->title.' en '.$product->subCategory->description
            .', consigue mas en '.$product->subCategory->category->description
            .' dentro de orbiagro.com.ve'
        );
        $this->seo()->opengraph()->setUrl(route('products.show', $id));

        return view('product.show', compact('product', 'visitedProducts', 'isUserValid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepo->getBySlugOrId($id);

        if (!$this->productRepo->canUserManipulate($product->user_id)) {
            return $this->redirectToroute('products.show', $id);
        }

        // TODO repo
        $makers = Maker::lists('name', 'id');

        $cats = $this->catRepo->getArraySortedWithSubCategories();

        return view('product.edit', compact('product', 'makers', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int            $id
     * @param  ProductRequest $request
     * @return Response
     */
    public function update($id, ProductRequest $request)
    {
        $product = $this->productRepo->update($id, $request->all());

        flash('El Producto ha sido actualizado con exito.');
        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->getById($id);

        return $this->destroyDeleteRestorePrototype(
            $product,
            'delete',
            'El Producto ha sido eliminado correctamente.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function forceDestroy($id)
    {
        $product = $this->productRepo->getByIdWithTrashed($id);

        return $this->destroyDeleteRestorePrototype(
            $product,
            'forceDelete',
            'El Producto ha sido eliminado permanentemente.'
        );
    }

    /**
     * Restores the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function restore($id)
    {
        $product = $this->productRepo->getByIdWithTrashed($id);

        return $this->destroyDeleteRestorePrototype(
            $product,
            'restore',
            'El Producto ha sido restaurado exitosamente.',
            'success',
            'products.show'
        );
    }

    /**
     * Ejecuta la operacion segun los paramentros. Este metodo sirve
     * para deshabilitar, eliminar y restaurar productos.
     *
     * @param  Product $product
     * @param  string $method
     * @param  string $message
     * @param  string $severity
     * @param  string $route
     *
     * @return Response
     */
    protected function destroyDeleteRestorePrototype(
        Product $product,
        $method,
        $message,
        $severity = 'info',
        $route = 'products.index'
    ) {
        if (!$this->productRepo->canUserManipulate($product->user_id)) {
            return $this->redirectToroute('products.show', $product->user_id);
        }

        $product->$method();

        if ($route == 'products.index') {
            return $this->redirectToroute($route, null, $message, $severity);
        }

        return $this->redirectToroute($route, $product->slug, $message, $severity);
    }

    /**
     * Restores the specified resource.
     *
     * @param  int     $id
     * @param  Request $request
     * @return Response
     */
    public function heroDetails($id, Request $request)
    {
        $this->validate($request, [
           'heroDetails' => 'required|string',
        ]);

        $product = $this->productRepo->getById($id);

        if (!$this->productRepo->canUserManipulate($product->user_id)) {
            abort(403);
        }

        $product->heroDetails = $request->heroDetails;

        $product->save();

        return ['status' => true];
    }
}
