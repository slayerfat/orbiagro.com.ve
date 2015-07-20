<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;

use App\Mamarrachismo\VisitsService;
use App\Mamarrachismo\Upload;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class SubCategoriesController extends Controller {

  use SEOToolsTrait;

  public $user, $userId, $subCat;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(SubCategory $subCat)
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
    $this->middleware('user.admin', ['except' => ['index', 'show']]);
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->subCat = $subCat;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
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

    $this->seo()->setTitle('Rubros en orbiagro.com.ve');
    $this->seo()->setDescription('Rubros en existencia en orbiagro.com.ve');
    $this->seo()->opengraph()->setUrl(action('SubCategoriesController@index'));

    return view('sub-category.index', compact('subCats', 'productsCollection'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $cats = Category::lists('description', 'id');

    return view('sub-category.create')->with([
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
    $cat = Category::findOrFail($request->input('category_id'));

    // para los archivos del rubro
    $upload->userId = $this->userId;

    $this->subCat->fill($request->all());

    $cat->sub_categories()->save($this->subCat);

    $upload->createImage($request->file('image'), $this->subCat);

    flash()->success('Rubro creado exitosamente.');
    return redirect()->action('SubCategoriesController@index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id, VisitsService $visits)
  {
    if(!$subCat = SubCategory::where('slug', $id)->first())
      $subCat = SubCategory::findOrFail($id);

    $subCats = $subCat->category->sub_categories()->get();

    $products = Product::where('sub_category_id', $subCat->id)->paginate(20);

    $visits->setNewVisit('subCat', $id);

    $this->seo()->setTitle("{$subCat->description} en orbiagro.com.ve");
    $this->seo()->setDescription("{$subCat->description} en {$subCat->category->description} dentro de orbiagro.com.ve");
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
    $this->subCat = SubCategory::findOrFail($id);

    $cats = Category::lists('description', 'id');

    return view('sub-category.edit')->with([
      'cats' => $cats,
      'subCat' => $this->subCat
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, SubCategoryRequest $request, Upload $upload)
  {
    $this->subCat = SubCategory::findOrFail($id)->load('image');

    $this->subCat->update($request->all());
    flash()->success('El Rubro ha sido actualizado correctamente.');

    if ($request->hasFile('image')) :
      if (!$upload->updateImage($request->file('image'), $this->subCat, $this->subCat->image)) :
        flash()->warning('El Rubro ha sido actualizado, pero la imagen asociada no pudo ser actualizada.');
      endif;
    endif;

    return redirect()->action('SubCategoriesController@show', $this->subCat->slug);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $this->subCat = SubCategory::findOrFail($id)->load('image');
    $this->subCat->image->delete();
    $this->subCat->delete();

    flash()->success('El Rubro ha sido eliminado correctamente.');
    return redirect()->action('SubCategoriesController@index');
  }

}
