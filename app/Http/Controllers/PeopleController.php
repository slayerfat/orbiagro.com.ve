<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests\PeopleRequest;
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
        $user = $this->userRepo->validateCreatePersonRequest($id);

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
        $user = $this->userRepo->storePerson($id, $request->all());

        flash()->success('Los datos personales han sido actualizados con exito.');

        return redirect()->action('UsersController@show', $user->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->validateCreatePersonRequest($id);

        if (is_null($user)) {
            return $this->redirectToRoute('usuarios.show', $$user->name);
        }

        $person = $user->person;

        $genders = Gender::lists('description', 'id');

        $nationalities = Nationality::lists('description', 'id');

        return view('people.edit', compact(
            'person',
            'user',
            'genders',
            'nationalities'
        ));
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
        $user = $this->userRepo->updatePerson($id, $request->all());

        flash()->success('Los datos personales han sido actualizados con exito.');

        return redirect()->action('UsersController@show', $user->name);
    }
}
