<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Orbiagro\Http\Requests\PeopleRequest;
use Orbiagro\Models\User;
use Orbiagro\Models\Gender;
use Orbiagro\Models\Nationality;
use Illuminate\View\View as Response;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class PeopleController
 * @package Orbiagro\Http\Controllers
 */
class PeopleController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Create a new controller instance.
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');

        // TODO ver si se implementa o no esto
        // $this->middleware('user.admin');

        $this->userRepo = $userRepo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int   $id
     *
     * @return Response
     */
    public function create($id)
    {
        $user = $this->userRepo->createPersonModel($id);

        if (is_null($user)) {
            return $this->redirectToRoute('usuarios.show', $$user->name);
        }

        $person = $this->userRepo->getEmptyPersonInstance();

        /**
         * @todo Repos de estos modelos
         */
        $genders = Gender::lists('description', 'id');

        $nationalities = Nationality::lists('description', 'id');

        return view('people.create', compact(
            'person',
            'user',
            'genders',
            'nationalities'
        ));
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
