<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;

use App\Mamarrachismo\VisitsService;
use App\Mamarrachismo\Upload\Image as Upload;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class SubCategoriesController extends Controller
{

    use SEOToolsTrait;

    protected $user;

    protected $subCat;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(SubCategory $subCat)
    {
        $rules = ['except' => ['index', 'show', 'indexByCategory']];

        $this->middleware('auth', $rules);

        $this->middleware('user.admin', $rules);

        $this->user   = Auth::user();

        $this->subCat = $subCat;
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $subCats = SubCategory::all();

        $productsCollection = $this->getProductsInSubCat($subCats);

        $this->seo()->setTitle('Rubros en orbiagro.com.ve');
        $this->seo()->setDescription('Rubros en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(action('SubCategoriesController@index'));

        return view('sub-category.index', compact('subCats', 'productsCollection'));
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function indexByCategory($categoryId)
    {
        if (!$subCats = Category::where('slug', $categoryId)->first()->subCategories) {
            $subCats = Category::findOrFail($categoryId)->subCategories;
        }

        $productsCollection = $this->getProductsInSubCat($subCats);

        $this->seo()->setTitle('Rubros en orbiagro.com.ve');
        $this->seo()->setDescription('Rubros en existencia en orbiagro.com.ve');
        $this->seo()->opengraph()->setUrl(action('SubCategoriesController@index'));

        return view('sub-category.index', compact('subCats', 'productsCollection'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        $cats = Category::lists('description', 'id');

        return view('sub-category.create')->with([
            'cats' => $cats,
            'subCat' => $this->subCat
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store(SubCategoryRequest $request, Upload $upload)
    {
        $cat = Category::findOrFail($request->input('category_id'));

        // para los archivos del rubro
        $upload->userId = $this->user->id;

        $this->subCat->fill($request->all());

        $cat->subCategories()->save($this->subCat);

        $upload->createImage($this->subCat, $request->file('image'));

        flash()->success('Rubro creado exitosamente.');
        return redirect()->action('SubCategoriesController@index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id, VisitsService $visits)
    {
        if (!$subCat = SubCategory::where('slug', $id)->first()) {
            $subCat = SubCategory::findOrFail($id);
        }

        $subCats = $subCat->category->subCategories()->get();

        $products = Product::where('sub_category_id', $subCat->id)->paginate(20);

        $visits->setNewVisit($subCat);

        $this->seo()->setTitle("{$subCat->description} en orbiagro.com.ve")->setDescription(
            "{$subCat->description} en {$subCat->category->description} dentro de orbiagro.com.ve"
        );

        // $this->seo()->setKeywords(); taxonomias
        $this->seo()->opengraph()->setUrl(action('SubCategoriesController@show', $id));

        return view('sub-category.show', compact('products', 'subCat', 'subCats'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $this->subCat = SubCategory::findOrFail($id);

        $cats = Category::lists('description', 'id');

        return view('sub-category.edit')->with([
            'cats' => $cats,
            'subCat' => $this->subCat
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id, SubCategoryRequest $request, Upload $upload)
    {
        $this->subCat = SubCategory::findOrFail($id)->load('image');

        $this->subCat->update($request->all());
        flash()->success('El Rubro ha sido actualizado correctamente.');

        if ($request->hasFile('image')) {
            if (!$upload->updateImage($request->file('image'), $this->subCat->image)) {
                flash()->warning('El Rubro ha sido actualizado, pero la imagen asociada no pudo ser actualizada.');
            }
        }

        return redirect()->action('SubCategoriesController@show', $this->subCat->slug);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $this->subCat = SubCategory::findOrFail($id);

        try {
            $this->subCat->delete();
        } catch (\Exception $e) {
            if ($e instanceof \QueryException || (int)$e->errorInfo[0] == 23000) {
                flash()->error('Para poder eliminar este Rubro, no deben haber productos asociados.');

                return redirect()->action('SubCategoriesController@show', $this->subCat->slug);
            }
            \Log::error($e);

            abort(500);
        }

        flash()->success('El Rubro ha sido eliminado correctamente.');
        return redirect()->action('SubCategoriesController@index');
    }

    /**
     * Busca aleatoriamente una cantidad de productos y regresa la coleccion.
     *
     * @param \Collection   $subCats Las categorias.
     * @param  integer      $ammount La cantidad a tomar.
     * @return \Collection
     */
    private function getProductsInSubCat($subCats, $ammount = 12)
    {
        $collection = collect();

        foreach ($subCats as $cat) {
            $collection->push($cat->products()->random()->take($ammount)->get());
        }

        return $collection;
    }
}
