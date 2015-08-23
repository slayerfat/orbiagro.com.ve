<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests\PeopleRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Person;
use App\Gender;
use App\Nationality;

class PeopleController extends Controller
{

    /**
     * @var Person
     */
    protected $person;

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int   $id
     * @param Guard $auth
     *
     * @return Response
     */
    public function create($id, Guard $auth)
    {
        if (!$user = User::where('name', $id)->first()) {
            $user = User::findOrFail($id);
        }

        if (!$auth->user()->isOwnerOrAdmin($user->id)) {
            return $this->redirectToRoute('usuarios.show', $$user->name);
        }

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
     * @param  int           $id
     * @param  PeopleRequest $request
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
     * @param  int      $id
     * @param  Guard    $auth
     * @return Response
     */
    public function edit($id, Guard $auth)
    {
        if (!$user = User::where('name', $id)->first()) {
            $user = User::findOrFail($id);
        }

        if (!$auth->user()->isOwnerOrAdmin($user->id)) {
            return $this->redirectToRoute('usuarios.show', $$user->name);
        }

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
     * @param  int           $id
     * @param  PeopleRequest $request
     *
     * @return Response
     */
    public function update($id, PeopleRequest $request)
    {
        $user = User::with('person')->findOrFail($id);
        $user->person->fill($request->all());

        $user->person->gender_id = $request->input('gender_id');
        $user->person->nationality_id = $request->input('nationality_id');

        $user->person->update();

        flash()->success('Los datos personales han sido actualizados con exito.');

        return redirect()->action('UsersController@show', $user->name);
    }
}
