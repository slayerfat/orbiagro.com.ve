<?php namespace App\Http\Controllers;

use Auth;
use Validator;
use Cookie;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mamarrachismo\VisitedProductsFinder;
use App\Mamarrachismo\Upload;
use App\Product;
use App\Image;
use App\File;
use App\Category;
use App\SubCategory;
use App\Visit;
use App\MapDetail;
use App\Direction;
use App\Maker;

class ProductsController extends Controller {

  public $user, $userId;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
    $this->user   = Auth::user();
    $this->userId = Auth::id();
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $products = Product::paginate(20);
    $cats     = Category::all();
    $subCats  = SubCategory::all();

    return view('product.index', compact('products', 'cats', 'subCats'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(Product $product)
  {
    $makers    = Maker::lists('name', 'id');
    $catModels = Category::with('sub_categories')->get();

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
    $upload->userId = $this->userId;
    $data       = $request->all();
    $product    = new Product($data);
    $dir        = new Direction($data);
    $map        = new MapDetail($data);

    // info adicional
    $product->created_by = $this->userId;
    $product->updated_by = $this->userId;
    $dir->updated_by = $this->userId;
    $dir->created_by = $this->userId;

    // se guardan los modelos
    $this->user->products()->save($product);
    $product->direction()->save($dir);
    $product->direction->map()->save($map);

    // se iteran las imagenes y se guardan los modelos
    if ($request->hasFile('images')) :
      $upload->createProductImages($request->file('images'), $product);
    else:
      $upload->createDefaultProductImage($product);
    endif;

    flash('El Producto ha sido creado con exito.');
    return redirect()->action('ProductsController@show', $product->id);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id, Request $request, VisitedProductsFinder $visitedFinder)
  {
    if(!$product = Product::where('slug', $id)->first())
    $product = Product::findOrFail($id);

    $visitedFinder->setNewProductVisit($product->id);
    $visitedProducts = $visitedFinder->getVisitedProducts();

    if($this->user) :
      if($this->user->isOwnerOrAdmin($product->id)) :
        $isUserValid = true;
      else :
        $isUserValid = false;
      endif;
    else :
      $isUserValid = false;
    endif;

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
    if($this->notOwner($id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;
    if($product = Product::where('slug', $id)->first())

    return view('product.edit', compact('product'));

    $product = Product::findOrFail($id);

    $makers = Maker::lists('name', 'id');

    $catModels = Category::with('sub_categories')->get();

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
    if($this->notOwner($id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('ProductsController@show', $id);
    endif;

    $product = Product::with('direction')->findOrFail($id);
    $product->updated_by = $this->userId;
    $product->update($request->all());

    // modificado porque el modelo no queria
    // quedarse guardado correctamente en BD.
    $direction = $product->direction;
    $direction->parish_id = $request->input('parish_id');
    $direction->details = $request->input('details');
    $direction->updated_by = $this->userId;
    $direction->save();

    if(!$map = $direction->map)
    {
      $map = new MapDetail;
      $map->direction_id = $direction->id;
    }
    $map->latitude = $request->input('latitude');
    $map->longitude = $request->input('longitude');
    $map->zoom = $request->input('zoom');
    $map->save();

    flash('El Producto ha sido actualizado con exito.');
    return redirect()->action('ProductsController@show', $id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

  /**
   * Para saber si el usuario es o no el dueño
   * de un producto para editar.
   *
   * @param int $id user's id.
   *
   * @return boolean
   */
  private function notOwner($id)
  {
    if($this->userId === $id) return false;
    if($this->user->isAdmin()) return false;

    return true;
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

    if(!$models) return null;

    foreach($models as $cat) :
      foreach($cat->sub_categories as $subCat) :
        $cats[$cat->description][$subCat->id] = $subCat->description;
      endforeach;
    endforeach;

    return $cats;
  }

}
