<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;

use App\Mamarrachismo\VisitsService;
use App\Mamarrachismo\Upload\Image as Upload;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class CategoriesController extends Controller
{

    use SEOToolsTrait;

    protected $user;

    protected $userId;

    protected $cat;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(Category $cat)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('user.admin', ['except' => ['index', 'show']]);
        $this->user   = Auth::user();
        $this->userId = Auth::id();
        $this->cat = $cat;
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $cats  = $this->cat->all()->load('subCategories');
        $productsCollection = collect();

        foreach ($cats as $cat) {
            foreach ($cat->subCategories as $subCat) {
                $productsCollection
                    ->push($subCat->products()->random()->take(6)->get());
            }
        }

        $this->seo()->setTitle('Categorias en orbiagro.com.ve');
        $this->seo()->setDescription('Categorias existentes es orbiagro.com.ve');
        // $this->seo()->setKeywords(); taxonomias
        $this->seo()->opengraph()->setUrl(action('CategoriesController@index'));

        return view('category.index', compact('cats', 'productsCollection'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('category.create')->with([
            'cat' => $this->cat
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store(CategoryRequest $request, Upload $upload)
    {
        // para los archivos del rubro
        $upload->userId = $this->userId;

        $this->cat->fill($request->all());
        $this->cat->save();

        $upload->createImage($request->file('image'), $this->cat);

        flash()->success('Categoria creada exitosamente.');
        return redirect()->action('CategoriesController@index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
        if (!$cat = Category::where('slug', $id)->first()) {
            $cat = Category::findOrFail($id);
        }


        $subCats = $cat->subCategories;

        $this->seo()->setTitle("{$cat->description} en orbiagro.com.ve");
        $this->seo()->setDescription("{$cat->description} existentes es orbiagro.com.ve");
        // $this->seo()->setKeywords(); taxonomias
        $this->seo()->opengraph()->setUrl(action('CategoriesController@show', $id));

        return view('category.show', compact('cat', 'subCats'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $this->cat = Category::findOrFail($id);

        return view('category.edit')->with([
            'cat' => $this->cat,
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id, CategoryRequest $request, Upload $upload)
    {
        $this->cat = category::findOrFail($id)->load('image');

        $this->cat->update($request->all());
        flash()->success('La Categoria ha sido actualizada correctamente.');

        if ($request->hasFile('image')) {
            if (!$upload->updateImage($request->file('image'), $this->cat->image)) {
                flash()->warning('La imagen asociada no pudo ser actualizada.');
            }
        }

        return redirect()->action('CategoriesController@show', $this->cat->slug);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $this->cat = category::findOrFail($id);

        try {
            $this->cat->delete();

        } catch (\Exception $e) {
            if ($e instanceof \QueryException || (int)$e->errorInfo[0] == 23000) {
                flash()->error('Para poder eliminar esta Categoria, no deben haber productos asociados.');
                return redirect()->action('CategoriesController@show', $this->cat->slug);
            }

            \Log::error($e);
            abort(500);
        }

        flash()->success('La Categoria ha sido eliminada correctamente.');
        return redirect()->action('CategoriesController@index');
    }
}
