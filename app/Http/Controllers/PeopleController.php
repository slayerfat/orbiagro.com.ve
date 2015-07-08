<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\PeopleRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use App\Person;
use App\Gender;
use App\Nationality;

class PeopleController extends Controller {

  public $person;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Person $person)
  {
    $this->middleware('auth');
    // $this->middleware('user.admin');
    $this->person = $person;
    $this->user = Auth::user();
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
    if(!$user = User::where('name', $id)->first())
      $user = User::findOrFail($id);

    if(!$this->user->isOwnerOrAdmin($user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->back();
    endif;

    $genders = Gender::lists('description', 'id');
    $nationalities = Nationality::lists('description', 'id');

    return view('people.create')->with([
      'person'        => $this->person,
      'user'          => $user,
      'genders'       => $genders,
      'nationalities' => $nationalities,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store($id, PeopleRequest $request)
  {
    $user = User::findOrFail($id);
    $this->person->fill($request->all());

    $this->person->gender_id = $request->input('gender_id');
    $this->person->nationality_id = $request->input('nationality_id');
    $user->person()->save($this->person);

    flash()->success('Los datos personales han sido actualizados con exito.');
    return redirect()->action('UsersController@show', $user->name);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    if(!$user = User::where('name', $id)->first())
      $user = User::findOrFail($id);

    if(!$this->user->isOwnerOrAdmin($user->id)) :
      flash()->error('Ud. no tiene permisos para esta accion.');
      return redirect()->action('UsersController@show', $user->name);
    endif;

    $genders = Gender::lists('description', 'id');
    $nationalities = Nationality::lists('description', 'id');

    return view('people.edit')->with([
      'person'        => $user->person,
      'user'          => $user,
      'genders'       => $genders,
      'nationalities' => $nationalities,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id, PeopleRequest $request)
  {
    $user = User::with('person')->findOrFail($id);
    $user->person->fill($request->all());
    $user->person->gender_id = $request->input('gender_id');
    $user->person->nationality_id = $request->input('nationality_id');

    $user->person->save();
    flash()->success('Los datos personales han sido actualizados con exito.');
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
