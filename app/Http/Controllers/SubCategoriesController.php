<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;

use App\Mamarrachismo\VisitedProductsFinder;
use App\Mamarrachismo\Upload;

class SubCategoriesController extends Controller {

  public $user, $userId, $subCat;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(SubCategory $subCat)
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->subCat = $subCat;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(VisitedProductsFinder $visitedFinder)
  {
    $visitedProducts = $visitedFinder->getVisitedProducts();

    // TODO: closure? : subcat ... function($query) ...
    // $todo = SubCategory::with(['products' => function($query){
    // 	// $query(get 9 random products...);
    // }]);
    // $todo = SubCategory::with(['products' => function($query){
    //   $query->random()->take(1);
    // }])->get();
    $subCats  = SubCategory::all();
    $productsCollection = collect();

    foreach ($subCats as $cat) {
      $productsCollection->push($cat->products()->random()->take(12)->get());
    }

    return view('sub-category.index', compact('subCats', 'productsCollection'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    if(!$this->user->isAdmin())
    {
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('HomeController@index');
    }
    $cats = Category::lists('description', 'id');

    return view('sub-category.create')-with([
      'cats' => $cats,
      'subCat' => $this->subCat
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(SubCategoryRequest $request, Upload $upload)
  {
    if(!$this->user->isAdmin())
    {
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('HomeController@index');
    }

    $cat = Category::findOrFail($request->input('category_id'));

    // para los archivos del rubro
    $upload->userId = $this->userId;

    $this->subCat->fill($request->all());

    $cat->sub_categories()->save($this->subCat);

    dd($cat);

    // para guardar la imagen y modelo
    if ($request->hasFile('image')) :
      $upload->createSubCategoryImage($request->file('image'), $product, $this->feature);
    endif;

    $subCat = new SubCategory($request->except('category_id', 'image'));
    return $subCat;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
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

}
