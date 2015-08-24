<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Orbiagro\Http\Requests;
use Orbiagro\Http\Requests\UserRequest;
use Orbiagro\Http\Controllers\Controller;
use Orbiagro\Models\User;
use Orbiagro\Profile;

class UsersController extends Controller
{

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param User $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth');

        $this->middleware(
            'user.admin',
            ['only' => 'index', 'forceDestroy', 'restore']
        );

        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::with('person')->withTrashed()->get();

        return view('user.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function products($id)
    {
        if (!$user = User::with('products')->where('name', $id)->first()) {
            $user = User::with('products')->findOrFail($id);
        }

        $productsBag = $user->products->groupBy('sub_category_id');

        return view('user.products', compact('user', 'productsBag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int    $id
     * @param  Guard  $auth
     * @return Response
     */
    public function productVisits($id, Guard $auth)
    {
        if (!$user = User::with(['visits' => function ($query) {
            $query->where('visitable_type', 'App\\Product')->orderBy('updated_at', 'desc');
        }])->where('name', $id)->first()) {
            $user = User::with(['visits' => function ($query) {
                $query->where('visitable_type', 'App\\Product')->orderBy('updated_at', 'desc');
            }])->findOrFail($id);
        }

        if (!$auth->user()->isOwnerOrAdmin($user->id)) {
            flash()->error('Ud. no tiene permisos para esta accion.');

            return redirect()->back();
        }

        // la coleccion de productos
        $products = collect();

        $user->visits->each(function ($visit) use ($products) {
            $products = $products->push($visit->visitable);
        });

        return view('user.productsVisits', compact('user', 'products'));
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
     * @param UserRequest $request
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $profile = Profile::findOrFail($request->input('profile_id'));

        $this->user->name     = $request->input('name');
        $this->user->email    = $request->input('email');
        $this->user->password = bcrypt($request->input('password'));

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
        if (!$user = User::with('person', 'products', 'profile')->where('name', $id)->first()) {
            $user = User::with('person', 'products', 'profile')->findOrFail($id);
        }

        $products = \App\Product::where('user_id', $user->id)->paginate(4);

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
        $user = User::with('person', 'products', 'profile')
            ->where('name', $id)
            ->withTrashed()
            ->first();

        if (!$user) {
            $user = User::with('person', 'products', 'profile')
                ->withTrashed()
                ->findOrFail($id);
        }

        $products = \App\Product::where('user_id', $user->id)->paginate(4);

        return view('user.show', compact('user', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int   $id
     * @param  Guard $auth
     * @return Response
     */
    public function edit($id, Guard $auth)
    {
        if (!$user = User::with('profile')->where('name', $id)->first()) {
            $user = User::with('profile')->findOrFail($id);
        }

        if (!$auth->user()->isOwnerOrAdmin($user->id)) {
            flash()->error('Ud. no tiene permisos para esta accion.');
            return redirect()->back();
        }

        $profiles = Profile::lists('description', 'id');

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
        $user = User::findOrFail($id);

        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->profile_id = $request->input('profile_id');

        if (trim($request->input('password')) != '') {
            $user->password = bcrypt($request->input('password'));
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
        $this->user = User::findOrFail($id);

        try {
            $this->user->delete();
        } catch (\Exception $e) {
            \Log::error($e);

            abort(500);
        }

        flash()->success('El Usuario ha sido eliminado correctamente.');

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
