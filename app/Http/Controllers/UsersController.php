<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Orbiagro\Http\Requests;
use Orbiagro\Http\Requests\UserRequest;
use Orbiagro\Models\Product;
use Orbiagro\Models\User;
use Orbiagro\Models\Profile;
use Illuminate\View\View as Response;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UsersController
 * @package Orbiagro\Http\Controllers
 */
class UsersController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');

        $this->middleware(
            'user.admin',
            ['only' => 'index', 'forceDestroy', 'restore']
        );

        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userRepo->getAllWithTrashed();

        return view('user.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function products($id)
    {
        $user = $this->userRepo->getByNameOrId($id);

        $productsBag = $user->products->groupBy('sub_category_id');

        return view('user.products', compact('user', 'productsBag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int    $id
     * @return Response
     */
    public function productVisits($id)
    {
        $user = $this->userRepo->getWithProductVisits($id);

        if (!$this->userRepo->canUserManipulate($user->id)) {
            flash()->error('Ud. no tiene permisos para esta accion.');

            return redirect()->back();
        }

        // la coleccion de productos
        $products = collect();

        /**
         * & requerido.
         *
         * @see http://php.net/manual/en/functions.anonymous.php
         */
        $user->visits->each(function ($visit) use (&$products) {
            $products = $products->push($visit->visitable);
        });

        return view('user.productsVisits', compact('user', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     * @param ProfileRepositoryInterface $profileRepo
     * @return Response
     */
    public function create(ProfileRepositoryInterface $profileRepo)
    {
        $profiles = $profileRepo->getLists();

        $user = $this->userRepo->getEmptyUserInstance();

        return view('user.create', compact('user', 'profiles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param UserRequest $request
     * @param ProfileRepositoryInterface $profileRepo
     * @return Response
     */
    public function store(UserRequest $request, ProfileRepositoryInterface $profileRepo)
    {
        $profile = $profileRepo->getById($request->input('profile_id'));

        $user = $this->userRepo->getEmptyUserInstance();

        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        $profile->users()->save($user);

        flash()->success('El Usuario ha sido creado exitosamente');
        return redirect()->route('users.show', $user->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepo->getWithChildrens($id);

        $products = $this->userRepo->getProducts($id);

        return view('user.show', compact('user', 'products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showTrashed($id)
    {
        $user = $this->userRepo->getSingleWithTrashed($id);

        $products = $this->userRepo->getProducts($id);

        return view('user.show', compact('user', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @param ProfileRepositoryInterface $profileRepo
     * @return Response
     */
    public function edit($id, ProfileRepositoryInterface $profileRepo)
    {
        $user = $this->userRepo->getByNameOrId($id);

        if (!$this->userRepo->canUserManipulate($user->id)) {
            flash()->error('Ud. no tiene permisos para esta accion.');
            return redirect()->back();
        }

        $profiles = $profileRepo->getLists();

        return view('user.edit', compact('user', 'profiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int         $id
     * @param  UserRequest $request
     *
     * @return Response
     */
    public function update($id, UserRequest $request)
    {
        if (trim($request->input('password')) == '') {
            flash()->warning('La contraseña no puede estar vacia.');

            return redirect()
                ->back()
                ->exceptInput($request->input('password'));
        }

        $user = $this->userRepo->getById($id);

        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->profile_id = $request->input('profile_id');
        $user->password   = bcrypt($request->input('password'));

        $user->save();

        flash()->success('El Usuario ha sido actualizado correctamente.');
        return redirect()->route('users.show', $user->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->userRepo->delete($id);

        return redirect()->action('UsersController@showTrashed', $this->user->id);
    }

    /**
     * Elimina forzadamente de la base de datos.
     *
     * @param  int $id
     * @return Response
     */
    public function forceDestroy($id)
    {
        $user = User::where('id', $id)->withTrashed()->firstOrFail();

        try {
            $user->forceDelete();
        } catch (\Exception $e) {
            if ($e instanceof \QueryException || (int)$e->errorInfo[0] == 23000) {
                flash()->error('Para poder eliminar este Usuario, no deben haber recursos asociados.');
                return redirect()->action('UsersController@show', $user->name);
            }
            \Log::error($e);

            abort(500);
        }

        flash()->success('El Usuario ha sido eliminado correctamente.');

        return redirect()->action('UsersController@index');
    }

    /**
     * UX del usuario que vaya a eliminar su cuenta.
     *
     * @param  int  $id
     * @return Response
     */
    public function preDestroy($id)
    {
        if (!$user = User::where('name', $id)->first()) {
            $user = User::findOrFail($id);
        }

        return view('user.destroy', compact('user'));
    }

    /**
     * Restores the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function restore($id)
    {
        $user = User::where('id', $id)->withTrashed()->firstOrFail();

        $user->restore();

        flash()->success('El Usuario ha sido restaurado exitosamente.');
        return redirect()->action('UsersController@show', $user->name);
    }
}
