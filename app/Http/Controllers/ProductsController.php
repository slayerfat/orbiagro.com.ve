<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Orbiagro\Http\Requests\ProductRequest;
use Orbiagro\Http\Controllers\Controller;
use Orbiagro\Mamarrachismo\VisitsService;
use Orbiagro\Models\Product;
use Orbiagro\Models\Category;
use Orbiagro\Models\SubCategory;
use Orbiagro\Models\MapDetail;
use Orbiagro\Models\Direction;
use Orbiagro\Models\Maker;

use Orbiagro\Mamarrachismo\Traits\Controllers\CanSaveUploads;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class ProductsController extends Controller
{

    use SEOToolsTrait, CanSaveUploads;

    /**
     * @var \Orbiagro\Models\User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
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

        $this->user = $auth->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  VisitsService $visits
     * @return Response
     */
    public function index(VisitsService $visits)
    {
        $products = Product::paginate(20);
        $cats     = Category::all();
        $subCats  = SubCategory::all();

        $visitedProducts = $visits->getVisitedResources(Product::class);

        $this->seo()->setTitle('Productos en orbiagro.com.ve');
        $this->seo()->setDescription('Productos y Articulos en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(action('ProductsController@index'));

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
        return $this->indexByParent(new Category, $categoryId, $visits);
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
        return $this->indexByParent(new SubCategory, $subCategoryId, $visits);
    }

    /**
     * Muestra el index segun la Categoria, Rubro, etc.
     *
     * @param  Model         $parent
     * @param  int           $parentId
     * @param  VisitsService $visits
     *
     * @return Response
     */
    private function indexByParent($parent, $parentId, VisitsService $visits)
    {
        if (!$products = $parent::where('slug', $parentId)->first()->products()->paginate(20)) {
            $products = $parent::findOrFail($parentId)->products()->paginate(20);
        }

        $visitedProducts = $visits->getVisitedResources(Product::class);

        $cats = Category::all();

        $description = '';

        if ($parent instanceof Category) {
            $subCats     = Category::where('slug', $parentId)->first()->subCategories;
            $description = $subCats->first()->category->description;
        } elseif ($parent instanceof SubCategory) {
            $subCats     = SubCategory::all();
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
     * @param  Product  $product
     *
     * @return Response
     */
    public function create(Product $product)
    {
        if ($this->user->isDisabled()) {
            flash()->error('Ud. no tiene permisos para esta accion.');

            return redirect()->back();
        }

        $makers    = Maker::lists('name', 'id');
        $catModels = Category::with('subCategories')->get();

        $cats = $this->toAsocArray($catModels);

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
        $data       = $request->all();
        $product    = new Product($data);
        $dir        = new Direction($data);
        $map        = new MapDetail($data);

        // se guardan los modelos
        $this->user->products()->save($product);
        $product->direction()->save($dir);
        $product->direction->map()->save($map);

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
        if (!$product = Product::with('user', 'subCategory')->where('slug', $id)->first()) {
            $product = Product::with('user', 'subCategory')->findOrFail($id);
        }

        $visits->setNewVisit($product);

        $visitedProducts = $visits->getVisitedResources(Product::class);

        if ($this->user) {
            $isUserValid = $this->user->isOwnerOrAdmin($product->user_id);
        }

        if (!isset($isUserValid)) {
            $isUserValid = false;
        }

        $this->seo()->setTitle(
            "{$product->title} - {$product->priceBs()}"
        )->setDescription(
            $product->title.' en '.$product->subCategory->description
            .', consigue mas en '.$product->subCategory->category->description
            .' dentro de orbiagro.com.ve'
        );
        $this->seo()->opengraph()->setUrl(action('ProductsController@show', $id));

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
        if (!$product = Product::with('user')->where('slug', $id)->first()) {
            $product = Product::with('user')->findOrFail($id);
        }

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToroute('products.show', $id);
        }

        $makers = Maker::lists('name', 'id');

        $catModels = Category::with('subCategories')->get();

        $cats = $this->toAsocArray($catModels);

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
        $product = Product::with('direction', 'user')->findOrFail($id);

        $product->update($request->all());

        // modificado porque el modelo no queria
        // quedarse guardado correctamente en BD.
        $direction = $product->direction;
        $direction->parish_id = $request->input('parish_id');
        $direction->details = $request->input('details');

        $direction->save();

        if (!$map = $direction->map) {
            $map = new MapDetail;
            $map->direction_id = $direction->id;
        }

        $map->latitude = $request->input('latitude');
        $map->longitude = $request->input('longitude');
        $map->zoom = $request->input('zoom');
        $map->save();

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
        $product = Product::findOrFail($id);

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
        $product = Product::withTrashed()->findOrFail($id);

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
        $product = Product::withTrashed()->findOrFail($id);

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
        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
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

        $product = Product::findOrFail($id);

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return abort(403);
        }

        $product->heroDetails = $request->heroDetails;

        $product->save();

        return ['status' => true];
    }

    /**
     * devuelve un array asociativo con los elementos
     * y sus subelementos.
     *
     * @todo abstraer a un metodo generico.
     *
     * @param \Illuminate\Database\Eloquent\Collection $models
     *
     * @return array
     */
    private function toAsocArray(\Illuminate\Database\Eloquent\Collection $models)
    {
        $cats = [];

        if (!$models) {
            return null;
        }

        foreach ($models as $cat) {
            foreach ($cat->subCategories as $subCat) {
                $cats[$cat->description][$subCat->id] = $subCat->description;
            }
        }

        return $cats;
    }
}
