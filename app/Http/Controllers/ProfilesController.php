<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Orbiagro\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Orbiagro\Profile;

class ProfilesController extends Controller
{

    /**
     * @var Profile
     */
    protected $profile;

    /**
     * @param Profile $profile
     */
    public function __construct(Profile $profile)
    {
        $this->middleware('auth');
        $this->middleware('user.admin');

        $this->profile = $profile;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $profiles = Profile::with('users')->paginate(5);

        return view('profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('profile.create')->with(['profile' => $this->profile]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|unique:profiles|max:40|min:5'
        ]);

        $this->profile->description = $request->input('description');
        $this->profile->save();

        flash()->success('El Perfil ha sido creado con exito.');

        return redirect()->action('ProfilesController@show', $this->profile->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (!$this->profile = Profile::with('users')->where('description', $id)->first()) {
            $this->profile = Profile::with('users')->findOrFail($id);
        }

        return view('profile.show')->with(['profile' => $this->profile]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->profile = Profile::findOrFail($id);

        return view('profile.edit')->with(['profile' => $this->profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @param  Request  $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:40|min:5|unique:profiles,description,'.$id
        ]);
        $this->profile = Profile::findOrFail($id);

        $this->profile->description = $request->input('description');
        $this->profile->save();

        flash()->success('El Perfil ha sido actualizado con exito.');

        return redirect()->action('ProfilesController@show', $this->profile->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->profile = Profile::findOrFail($id);

        if (!$this->profile->users->isEmpty()) {
            flash()->error('Para poder eliminar este perfil, debe estar vacio.');

            return redirect()->action('ProfilesController@show', $this->profile->id);
        }

        $this->profile->delete();

        flash()->info('El Perfil ha sido eliminado correctamente.');

        return redirect()->action('ProfilesController@index');
    }
}
