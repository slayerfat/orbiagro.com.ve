<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;

use App\Mamarrachismo\VisitedProductsFinder;
use App\Mamarrachismo\Upload;

class CategoriesController extends Controller {

  public $user, $userId, $cat;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Category $cat)
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->cat = $cat;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(VisitedProductsFinder $visitedFinder)
  {
    $visitedProducts = $visitedFinder->getVisitedProducts();

    $cats  = $this->cat->all()->load('sub_categories');
    $productsCollection = collect();

    foreach ($cats as $cat) :
      foreach ($cat->sub_categories as $subCat) :
        $productsCollection->push($subCat->products()->random()->take(12)->get());
      endforeach;
    endforeach;

    return view('category.index', compact('cats', 'productsCollection', 'visitedProducts'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //
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
