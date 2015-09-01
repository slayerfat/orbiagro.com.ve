<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Orbiagro\Http\Requests\UserRequest;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;

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
     * @return View
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
     * @return View
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
     * @return View|RedirectResponse
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
     * @return View
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
     * @return RedirectResponse
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
     * @return View
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
     * @return View
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
     * @return View
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
     * @return RedirectResponse
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
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $result = $this->userRepo->delete($id);

        if ($result === true) {
            return redirect()->route('users.index');
        }

        return redirect()->route('users.trashed', $result->id);
    }

    /**
     * Elimina forzadamente de la base de datos.
     *
     * @param  int $id
     * @return RedirectResponse
     */
    public function forceDestroy($id)
    {
        $result = $this->userRepo->forceDelete($id);

        if ($result === true) {
            return redirect()->route('users.index');
        }

        return redirect()->route('users.show', $result->name);
    }

    /**
     * UX del usuario que vaya a eliminar su cuenta.
     *
     * @param  int  $id
     * @return View
     */
    public function preDestroy($id)
    {
        $user = $this->userRepo->getByNameOrId($id);

        return view('user.destroy', compact('user'));
    }

    /**
     * Restores the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function restore($id)
    {
        $user = $this->userRepo->restore($id);

        flash()->success('El Usuario ha sido restaurado exitosamente.');
        return redirect()->route('users.show', $user->name);
    }
}
