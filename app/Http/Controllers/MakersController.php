<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\MakerRequest;
use App\Http\Controllers\Controller;

use App\Maker;

use App\Mamarrachismo\Upload;

class MakersController extends Controller {

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Maker $maker)
  {
    $this->middleware('auth', ['except' => ['show']]);
    $this->middleware('user.admin', ['except' => ['show']]);
    $this->user   = Auth::user();
    $this->userId = Auth::id();
    $this->maker = $maker;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $makers = Maker::with('products')->get();

    return view('maker.index', compact('makers'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('maker.create')->with(['maker' => $this->maker]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(MakerRequest $request, Upload $upload)
  {
    $this->maker->fill($request->all());

    $this->maker->save();

    // para los archivos
    $upload->userId = $this->userId;

    $upload->createImage($request->file('image'), $this->maker);

    flash()->success('Fabricante creado exitosamente.');
    return redirect()->action('MakersController@index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $this->maker = Maker::with('products')->findOrFail($id);
    return view('maker.show')->with(['maker' => $this->maker]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
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
