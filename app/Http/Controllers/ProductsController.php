<?php namespace Orbiagro\Http\Controllers;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Orbiagro\Http\Requests\ProductRequest;
use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Orbiagro\Mamarrachismo\VisitsService;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\MakerRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;
use Orbiagro\Repositories\Interfaces\QuantityTypeRepositoryInterface;
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
     * @var QuantityTypeRepositoryInterface
     */
    private $quantityTypeRepo;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepositoryInterface $productRepo
     * @param CategoryRepositoryInterface $catRepo
     * @param SubCategoryRepositoryInterface $subCatRepo
     * @param QuantityTypeRepositoryInterface $quantityTypeRepo
     */
    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $catRepo,
        SubCategoryRepositoryInterface $subCatRepo,
        QuantityTypeRepositoryInterface $quantityTypeRepo
    ) {
        $rules = [
            'except' =>
                [
                    'index',
                    'show',
                    'indexByCategory',
                    'indexBySubCategory',
                ],
        ];

        $this->middleware('auth', $rules);
        $this->middleware('user.unverified', $rules);

        $this->catRepo          = $catRepo;
        $this->subCatRepo       = $subCatRepo;
        $this->productRepo      = $productRepo;
        $this->quantityTypeRepo = $quantityTypeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  VisitsService $visits
     * @return View
     */
    public function index(VisitsService $visits)
    {
        /** @var \Illuminate\Support\Collection $products */
        $products = $this->productRepo->getPaginated(20);
        $cats     = $this->catRepo->getAll();
        $subCats  = $this->subCatRepo->getAll();

        // si existen productos y tiene image se asigna,
        // de lo contrario se asigna la de un rubro
        $image   = $products->random() ? $products->random()->images->first() ?
            $products->random()->images->first()->small : $subCats->random()->image->small
            : $subCats->random()->image->small;
        $paths   = $this->makeOpenGraphImages($products, 4);
        $paths[] = asset($image);

        $visitedProducts = $visits->getVisitedResources(
            $this->productRepo->getEmptyInstance()
        );

        $this->seo()->setTitle('Productos en orbiagro.com.ve');
        $this->seo()->setDescription('Productos y Articulos en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(route('products.index'));
        $this->seo()->opengraph()->addImages($paths);
        $this->seo()->twitter()->addImage(asset($image));

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
     * @param  int $categoryId
     * @param  VisitsService $visits
     *
     * @return View
     */
    public function indexByCategory($categoryId, VisitsService $visits)
    {
        return $this->indexByParent('category', $categoryId, $visits);
    }

    /**
     * Muestra el index segun la Categoria, Rubro, etc.
     *
     * @param  string $parent
     * @param  int $parentId
     * @param  VisitsService $visits
     *
     * @return View
     */
    private function indexByParent($parent, $parentId, VisitsService $visits)
    {
        /** @var \Orbiagro\Models\Product $products */
        $products = $this->productRepo->getByParentSlugOrId($parent, $parentId);

        $visitedProducts = $visits->getVisitedResources(
            $this->productRepo->getEmptyInstance()
        );

        $cats = $this->catRepo->getAll();

        $description = '';

        if ($parent == 'category') {
            $cat = $this->catRepo->getBySlugOrId($parentId);

            $subCats = $cat->subCategories;

            $description = $cat->description;
        } elseif ($parent == 'subCategory') {
            $subCats = $this->subCatRepo->getAll();

            $description = $products->first()->subCategory->description;
        }

        $this->seo()->setTitle(
            'Productos de '
            . $description
            . ' en orbiagro.com.ve'
        )->setDescription(
            'Productos y Articulos de '
            . $description
            . ' en existencia en orbiagro.com.ve'
        );

        return view('product.index', compact(
            'products',
            'cats',
            'subCats',
            'visitedProducts'
        ));
    }

    /**
     * Muestra el index segun el Rubro.
     *
     * @param  int $subCategoryId
     * @param  VisitsService $visits
     *
     * @return View
     */
    public function indexBySubCategory($subCategoryId, VisitsService $visits)
    {
        return $this->indexByParent('subCategory', $subCategoryId, $visits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param MakerRepositoryInterface $maker
     * @return View|RedirectResponse
     */
    public function create(MakerRepositoryInterface $maker)
    {
        if ($this->productRepo->isCurrentUserDisabled()) {
            flash()->error('Ud. no tiene permisos para esta accion.');

            return redirect()->back();
        }

        $makers        = $maker->getLists();
        $product       = $this->productRepo->getEmptyInstance();
        $cats          = $this->catRepo->getArraySortedWithSubCategories();
        $quantityTypes = $this->quantityTypeRepo->getLists();

        return view('product.create', compact('product', 'makers', 'cats', 'quantityTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productRepo->store($request->all());
        flash()->success('El Producto ha sido creado con exito.');

        // se iteran las imagenes y se guardan los modelos
        $this->createImages($request, $product);

        return redirect()->route('products.show', $product->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param  VisitsService $visits
     * @return View
     */
    public function show($id, VisitsService $visits)
    {
        $product = $this->productRepo->getBySlugOrId($id);

        $visits->setNewVisit($product);

        $visitedProducts = $visits->getVisitedResources(
            $this->productRepo->getEmptyInstance()
        );

        $isUserValid = $this->productRepo->canUserManipulate($product->user_id);

        $this->seo()->setTitle(
            "{$product->title} - {$product->priceBs()}"
        )->setDescription(
            $product->title . ' en ' . $product->subCategory->description
            . ', consigue mas en ' . $product->subCategory->category->description
            . ' dentro de orbiagro.com.ve'
        );

        $paths = [];

        foreach ($product->images as $image) {
            $paths[] = asset($image->small);
        }

        $this->seo()->opengraph()->setUrl(route('products.show', $id));
        $this->seo()->opengraph()->addImages($paths);
        $this->seo()->twitter()->addImage(asset($product->images->first()->small));

        return view('product.show', compact('product', 'visitedProducts', 'isUserValid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param MakerRepositoryInterface $maker
     * @return View
     */
    public function edit($id, MakerRepositoryInterface $maker)
    {
        $product = $this->productRepo->getBySlugOrId($id);

        if (!$this->productRepo->canUserManipulate($product->user_id)) {
            return $this->redirectToroute('products.show', $id);
        }

        $makers        = $maker->getLists();
        $cats          = $this->catRepo->getArraySortedWithSubCategories();
        $quantityTypes = $this->quantityTypeRepo->getLists();

        return view('product.edit', compact('product', 'makers', 'cats', 'quantityTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  ProductRequest $request
     * @return RedirectResponse
     */
    public function update($id, ProductRequest $request)
    {
        $product = $this->productRepo->update($id, $request->all());

        flash('El Producto ha sido actualizado con éxito.');

        return redirect()->route('products.show', $product->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return RedirectResponse
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
     * Ejecuta la operacion segun los paramentros. Este metodo sirve
     * para deshabilitar, eliminar y restaurar productos.
     *
     * @param  $product
     * @param  string $method
     * @param  string $message
     * @param  string $severity
     * @param  string $route
     *
     * @return RedirectResponse
     */
    protected function destroyDeleteRestorePrototype(
        $product,
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return RedirectResponse
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
     * @param  int $id
     * @return RedirectResponse
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
     * Restores the specified resource.
     *
     * @param  int $id
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
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

        $product->heroDetails = $request->input('heroDetails');

        $product->save();

        return ['status' => true];
    }
}
