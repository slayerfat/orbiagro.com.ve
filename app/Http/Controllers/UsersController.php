<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use App\Profile;

class UsersController extends Controller {

  public $user;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(User $user)
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
    $this->user = $user;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    if(!Auth::user()->isAdmin())
    {
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('HomeController@index');
    }

    $profiles = Profile::lists('description', 'id');

    return view('user.create')->with([
      'user'     => $this->user,
      'profiles' => $profiles,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(UserRequest $request)
  {
    if(!Auth::user()->isAdmin())
    {
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('HomeController@index');
    }

    $profile = Profile::findOrFail($request->input('profile_id'));

    $this->user->fill($request->all());

    $profile->users()->save($this->user);

    flash()->success('El Usuario ha sido creado exitosamente');
    return redirect()->action('UsersController@show', $this->user->id);
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
