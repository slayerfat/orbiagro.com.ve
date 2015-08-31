<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View\View as Response;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfilesController extends Controller
{

    /**
     * @var ProfileRepositoryInterface
     */
    private $profileRepo;

    /**
     * @param ProfileRepositoryInterface $profileRepo
     */
    public function __construct(ProfileRepositoryInterface $profileRepo)
    {
        $this->middleware('auth');
        $this->middleware('user.admin');

        $this->profileRepo = $profileRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $profiles = $this->profileRepo->getPaginated(5);

        return view('profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $profile = $this->profileRepo->getEmptyInstance();

        return view('profile.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|unique:profiles|max:40|min:5'
        ]);

        $profile = $this->profileRepo->store($request->all());

        flash()->success('El Perfil ha sido creado con exito.');

        return redirect()->route('profiles.show', $profile->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $profile = $this->profileRepo->getByDescription($id);

        return view('profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $profile = $this->profileRepo->getById($id);

        return view('profile.edit', compact('profile'));
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

        $profile = $this->profileRepo->update($id, $request->all());

        flash()->success('El Perfil ha sido actualizado con exito.');

        return redirect()->route('profiles.show', $profile->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        flash()->info('El Perfil ha sido eliminado correctamente.');

        if (!$this->profileRepo->destroy($id)) {
            flash()->error('Para poder eliminar este perfil, debe estar vacio.');
        }

        return redirect()->route('profiles.index');
    }
}
