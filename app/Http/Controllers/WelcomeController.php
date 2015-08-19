<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

  /*
  |--------------------------------------------------------------------------
  | Welcome Controller
  |--------------------------------------------------------------------------
  |
  | This controller renders the "marketing page" for the application and
  | is configured to only allow guests. Like most of the other sample
  | controllers, you are free to modify or remove it as you desire.
  |
  */

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('user.admin');
  }

  /**
   * Show the application welcome screen to the user.
   *
   * @return Response
   */
  public function index()
  {
    return $this->test();
    // return view('welcome');
  }

  protected function test()
  {
    $method = 'error';
    flash()->$method('Ud. no tiene permisos para esta accion.');
    return redirect()->action('HomeController@index');
  }

}
