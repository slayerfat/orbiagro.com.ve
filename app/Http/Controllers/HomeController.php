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
    $sub_category = SubCategory::has('products')->random()->first();

    return view('home.index', compact('sub_category'));
  }

  public function unverified()
  {
    $user  = Auth::user();

    return view('auth.verification', compact('user'));
  }

}
