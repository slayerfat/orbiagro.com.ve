<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mamarrachismo\VisitsService;
use App\Mamarrachismo\Upload\Image as Upload;

use App\Product;
use App\Category;
use App\SubCategory;
use App\MapDetail;
use App\Direction;
use App\Maker;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class ProductsController extends Controller
{

    use SEOToolsTrait;

    protected $user;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
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

        $this->user   = Auth::user();
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(VisitsService $visits)
    {
        $products = Product::paginate(20);
        $cats     = Category::all();
        $subCats  = SubCategory::all();

        $visitedProducts = $visits->getVisitedResources(new Product);

        $this->seo()->setTitle('Productos en orbiagro.com.ve');
        $this->seo()->setDescription('Productos y Articulos en existencia en orbiagro.com.ve');
        // $this->seo()->setKeywords(); taxonomias
        $this->seo()->opengraph()->setUrl(action('ProductsController@index'));

        return view('product.index', compact(
            'products',
            'cats',
            'subCats',
            'visitedProducts'
        ));
    }

    /**
    * Display a listing of the resource according to category.
    *
    * @todo refactor
    *
    * @return Response
    */
    public function indexByCategory($categoryId, VisitsService $visits)
    {
        if (!$products = Category::where('slug', $categoryId)->first()->products()->paginate(20)) {
            $products  = Category::findOrFail($categoryId)->products()->paginate(20);
        }

        $cats     = Category::all();
        $subCats  = Category::where('slug', $categoryId)->first()->subCategories;

        $visitedProducts = $visits->getVisitedResources(new Product);

        $this->seo()->setTitle(
            'Productos de '
            .$subCats->first()->category->description
            .' en orbiagro.com.ve'
        )->setDescription(
            'Productos y Articulos de '
            .$subCats->first()->category->description
            .' en existencia en orbiagro.com.ve'
        );

        $this->seo()->opengraph()->setUrl(action('ProductsController@index'));

        return view('product.index', compact(
            'products',
            'cats',
            'subCats',
            'visitedProducts'
        ));
    }

    /**
    * Display a listing of the resource according to sub-category.
    *
    * @todo refactor
    *
    * @return Response
    */
    public function indexBySubCategory($subCategoryId, VisitsService $visits)
    {
        if (!$products = SubCategory::where('slug', $subCategoryId)->first()->products()->paginate(20)) {
            $products = SubCategory::findOrFail($subCategoryId)->products()->paginate(20);
        }

        $cats     = Category::all();
        $subCats  = SubCategory::all();

        $visitedProducts = $visits->getVisitedResources(new Product);

        $this->seo()->setTitle(
            'Productos de '
            .$products->first()->subCategory->description
            .' en orbiagro.com.ve'
        )->setDescription(
            'Productos y Articulos de '
            .$products->first()->subCategory->description
            .' en existencia en orbiagro.com.ve'
        );

        $this->seo()->opengraph()->setUrl(action('ProductsController@index'));

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
    * @return Response
    */
    public function store(ProductRequest $request, Upload $upload)
    {
        // se crean los modelos
        $upload->userId = Auth::id();
        $data       = $request->all();
        $product    = new Product($data);
        $dir        = new Direction($data);
        $map        = new MapDetail($data);

        // se guardan los modelos
        $this->user->products()->save($product);
        $product->direction()->save($dir);
        $product->direction->map()->save($map);

        // se iteran las imagenes y se guardan los modelos
        $upload->createImages($request->file('images'), $product);

        flash()->success('El Producto ha sido creado con exito.');
        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id, VisitsService $visits)
    {
        if (!$product = Product::with('user', 'subCategory')->where('slug', $id)->first()) {
            $product = Product::with('user', 'subCategory')->findOrFail($id);
        }

        $visits->setNewVisit($product);
        $visitedProducts = $visits->getVisitedResources($product);

        if ($this->user) {
            $isUserValid = $this->user->isOwnerOrAdmin($product->user_id);
        }

        if (!isset($isUserValid)) {
            $isUserValid = false;
        }

        $this->seo()->setTitle(
            "{$product->title} - {$product->price_bs()}"
        )->setDescription(
            $product->title.' en '.$product->subCategory->description
            .', consigue mas en '.$product->subCategory->category->description
            .' dentro de orbiagro.com.ve'
        );

        // $this->seo()->setKeywords(); taxonomias
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
            return $this->redirectToRoute('productos.show', $id);
        }

        $makers = Maker::lists('name', 'id');

        $catModels = Category::with('subCategories')->get();

        $cats = $this->toAsocArray($catModels);

        return view('product.edit', compact('product', 'makers', 'cats'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
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

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToRoute('productos.show', $id);
        }

        $product->delete();

        flash()->info('El Producto ha sido eliminado correctamente.');
        return redirect()->action('ProductsController@index');
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

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToRoute('productos.index');
        }

        $product->forceDelete();

        flash()->info('El Producto ha sido eliminado permanentemente.');
        return redirect()->action('ProductsController@index');
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

        if (!$this->user->isOwnerOrAdmin($product->user_id)) {
            return $this->redirectToRoute('productos.index');
        }

        $product->restore();

        flash()->success('El Producto ha sido restaurado exitosamente.');
        return redirect()->action('ProductsController@show', $product->slug);
    }

    /**
    * devuelve un array asociativo con los elementos
    * y sus subelementos.
    *
    * @todo abstraer a un metodo generico.
    *
    * @param IlluminateDatabaseEloquentCollection $models
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
