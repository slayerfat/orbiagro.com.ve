<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\FeatureRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Feature;

use App\Mamarrachismo\Upload\File as UploadFile;
use App\Mamarrachismo\Upload\Image as UploadImage;

class FeaturesController extends Controller
{

    protected $user;

    protected $userId;

    protected $feature;

    /**
    * Create a new controller instance.
    *
    * @method __construct
    * @param  Feature     $feature
    *
    * @return void
    */
    public function __construct(Feature $feature)
    {
        $this->middleware('auth');

        $this->user   = Auth::user();
        $this->userId = Auth::id();

        $this->feature = $feature;
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create($id)
    {
        $product = Product::findOrFail($id)->load('features', 'user');

        if ($product->features->count() < 5) {
            if ($this->user->isOwnerOrAdmin($product->user->id)) {
                return view('feature.create')->with([
                    'product' => $product,
                    'feature' => $this->feature
                ]);
            }

            return $this->redirectToRoute('productos.show', $product->slug);
        }

        return $this->redirectToRoute(
            'productos.show',
            $product->slug,
            'Este Producto ya posee 5 Distintivos, por favor actualice los existentes.'
        );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @method store
    * @param  int            $id
    * @param  FeatureRequest $request
    * @param  UploadImage    $uploadImage clase para subir imagenes.
    * @param  UploadFile     $uploadFile  clase para subir archivos.
    *
    * @return Response
    */
    public function store($id, FeatureRequest $request, UploadImage $uploadImage, UploadFile $uploadFile)
    {
        $product = Product::findOrFail($id);

        // para los archivos del feature
        $uploadImage->userId = $this->userId;
        $uploadFile->userId  = $this->userId;

        // el producto puede tener como maximo 5 features
        if ($product->features->count() >= 5) {
            return $this->redirectToRoute(
                'productos.show',
                $product->slug,
                'Este Producto ya posee 5 Distintivos, por favor actualice los existentes.'
            );
        }

        $this->feature->title       = $request->input('title');
        $this->feature->description = $request->input('description');

        $product->features()->save($this->feature);

        flash('Distintivo creado correctamente.');

        // para guardar la imagen y modelo
        try {
            $uploadImage->createImage($request->file('image'), $this->feature);
        } catch (\Exception $e) {
            flash()->warning('Distintivo creado, pero la imagen asociada no pudo ser creada.');
        }

        if ($request->file('file')) {
            try {
                $uploadFile->createFile($request->file('file'), $this->feature);
            } catch (\Exception $e) {
                flash()->warning('Distintivo creado, pero el archivo no pudo ser procesado.');
            }
        }

        return redirect()->action('productos.show', $product->slug);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $this->feature = Feature::findOrFail($id)->load('product', 'product.user');

        if (!$this->user->isOwnerOrAdmin($this->feature->product->user->id)) {
            return $this->redirectToRoute('productos.show', $this->feature->product->slug);
        }

        return view('feature.edit')->with(['feature' => $this->feature]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int            $id
    * @param  FeatureRequest $request
    * @param  UploadImage    $uploadImage clase para subir imagenes.
    * @param  UploadFile     $uploadFile  clase para subir archivos.
    *
    * @return Response
    */
    public function update($id, FeatureRequest $request, UploadImage $uploadImage, UploadFile $uploadFile)
    {
        // se carga el producto para el redirect (id)
        $this->feature = Feature::findOrFail($id)->load('product', 'product.user');

        // para dates
        // para los archivos del feature
        $uploadImage->userId = $this->userId;
        $uploadFile->userId  = $this->userId;

        $this->feature->update($request->all());

        flash('El Distintivo ha sido actualizado correctamente.');

        // TODO: mejorar?
        // para guardar la imagen y modelo
        if ($request->hasFile('image')) {
            try {
                $uploadImage->updateImage($request->file('image'), $this->feature->image);
            } catch (\Exception $e) {
                flash()->warning('El Distintivo ha sido actualizado, pero la imagen asociada no pudo ser actualizada.');
            }
        }

        if ($request->hasFile('file')) {
            try {
                $uploadFile->updateFile($request->file('file'), $this->feature, $this->feature->file);
            } catch (\Exception $e) {
                flash()->warning('Distintivo actualizado, pero el archivo no pudo ser actualizado.');
            }
        }

        return redirect()->action('productos.show', $this->feature->product->slug);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $this->feature = Feature::findOrFail($id)->load('product', 'product.user');

        if (!$this->user->isOwnerOrAdmin($this->feature->product->user->id)) {
            return $this->redirectToRoute('productos.show', $this->feature->product->slug);
        }

        $this->feature->delete();

        return $this->redirectToRoute(
            'productos.show',
            $this->feature->product->slug,
            'El Distintivo ha sido eliminado correctamente.',
            'info'
        );
    }
}
