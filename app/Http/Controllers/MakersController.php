<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests\MakerRequest;
use App\Http\Controllers\Controller;
use App\Mamarrachismo\Upload\Image as Upload;
use App\Maker;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class MakersController extends Controller
{

    use SEOToolsTrait;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(Maker $maker)
    {
        $rules = ['except' => ['show']];

        $this->middleware('auth', $rules);

        $this->middleware('user.admin', $rules);

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

        $this->seo()->setTitle('Fabricantes en orbiagro.com.ve');
        $this->seo()->setDescription('Fabricantes existentes es orbiagro.com.ve');
        // $this->seo()->setKeywords(); taxonomias
        $this->seo()->opengraph()->setUrl(action('MakersController@index'));

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
     * @param  MakerRequest $request
     * @param  Upload       $upload
     * @param  Guard        $auth
     *
     * @return Response
     */
    public function store(MakerRequest $request, Upload $upload, Guard $auth)
    {
        $this->maker->fill($request->all());

        $this->maker->save();

        // para los archivos
        $upload->userId = $auth->user()->id;

        $upload->createImage($this->maker, $request->file('image'));

        flash()->success('Fabricante creado exitosamente.');
        return redirect()->action('MakersController@show', $this->maker->slug);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
        if (!$this->maker = Maker::with('products')->where('slug', $id)->first()) {
            $this->maker = Maker::with('products')->findOrFail($id);
        }


        $this->seo()->setTitle("{$this->maker->name} y sus articulos en orbiagro.com.ve");
        $this->seo()->setDescription("{$this->maker->name} y sus productos relacionados en orbiagro.com.ve");
        $this->seo()->opengraph()->setUrl(action('MakersController@show', $id));

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
        $this->maker = Maker::findOrFail($id);

        return view('maker.edit')->with(['maker' => $this->maker]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int          $id
     * @param  MakerRequest $request
     * @param  Upload       $upload
     * @param  Guard        $auth
     * @return Response
     */
    public function update($id, MakerRequest $request, Upload $upload, Guard $auth)
    {
        $this->maker = Maker::findOrFail($id)->load('image');
        $this->maker->update($request->all());

        flash()->success('Fabricante Actualizado exitosamente.');

        $upload->userId = $auth->user()->id;

        if ($request->hasFile('image')) {
            try {
                $upload->updateImage($request->file('image'), $this->maker->image);
            } catch (\Exception $e) {
                flash()->warning('La imagen asociada no pudo ser actualizada.');
            }
        }

        return redirect()->action('MakersController@show', $this->maker->slug);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $this->maker = Maker::findOrFail($id);

        try {
            $this->maker->delete();
        } catch (\Exception $e) {
            if ($e instanceof \QueryException || (int)$e->errorInfo[0] == 23000) {
                flash()->error('No deben haber productos asociados.');

                return redirect()->action('MakersController@show', $this->maker->slug);
            }
            \Log::error($e);
            abort(500);
        }

        flash()->success('El Fabricante ha sido eliminado correctamente.');
        return redirect()->action('MakersController@index');
    }
}
