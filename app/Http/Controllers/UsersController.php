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
    $this->middleware('auth');
    $this->middleware('user.admin');
    $this->user = $user;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $users = User::with('person')->get();

    return view('user.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
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
    $profile = Profile::findOrFail($request->input('profile_id'));

    $this->user->name     = $request->input('name');
    $this->user->email    = $request->input('email');
    $this->user->password = $request->input('password');

    $profile->users()->save($this->user);

    flash()->success('El Usuario ha sido creado exitosamente');
    return redirect()->action('UsersController@show', $this->user->name);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    if(!$user = User::with('person', 'products', 'profile')->where('name', $id)->first())
      $user = User::with('person', 'products', 'profile')->findOrFail($id);

    $products = \App\Product::where('user_id', $user->id)->paginate(4);

    return view('user.show', compact('user', 'products'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::with('profile')->findOrFail($id);

    $profiles = Profile::lists('description', 'id');

    return view('user.edit', compact('user', 'profiles'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, UserRequest $request)
  {
    $user = User::findOrFail($id);

    $user->name       = $request->input('name');
    $user->email      = $request->input('email');
    $user->profile_id = $request->input('profile_id');

    if (trim($request->input('password')) != '')
    {
      $user->password = $request->input('password');
    }

    $user->save();

    flash()->success('El Usuario ha sido actualizado correctamente.');
    return redirect()->action('UsersController@show', $user->name);
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
