<?php namespace App\Http\Controllers;

use App\SubCategory;

class HomeController extends Controller {

  /**
   * Show the application dashboard to the user.
   *
   * @return Response
   */
  public function index()
  {
    $sub_category = SubCategory::has('products')->orderByRaw('rand()')->first();

    return view('home.index', compact('sub_category'));
  }

}
