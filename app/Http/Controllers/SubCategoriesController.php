<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\SubCategory;

use App\Mamarrachismo\VisitedProductsFinder;

class SubCategoriesController extends Controller {

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
