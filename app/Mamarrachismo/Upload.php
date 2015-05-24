<?php namespace App\Mamarrachismo;

use Auth;
use App\Product;
use App\Feature;
use App\SubCategory;
use App\Category;
use App\Image;

/**
 *
 */
class Upload {

  /**
   * @var int
   */
  public $userId;

  /**
   * la direccion para guardar el archivo relacionado al modelo.
   * @var string
   */
  private $path;

  /**
   * reglas para el validador.
   * @var array
   */
  private $imageRules = ['image' => 'required|mimes:jpeg,bmp,png|max:10000'];

  public function __construct($id = null)
  {
    $this->userId = $id;
  }

  /**
   * crea la(s) imagen(es) relacionadas con algun producto.
   *
   * @param array   $array   El array con los objetos UploadedFiles.
   * @param Product $product El modelo de producto.
   *
   * @return boolean
   */
  public function createProductImages(array $array, Product $product)
  {
    $this->path = $this->generatePathFromModel($product);

    foreach($array as $file) :

      // el validador
      $validator = \Validator::make(['image' => $file], $this->imageRules);
      if ($validator->fails())
      {
        // si existe entre 0 y 1 en el array y la imagen es invalida
        // se crea la imagen por defecto
        if (sizeOf($array) <= 1)
        {
          // si las imagenes no son validas crea una imagen por defecto
          return $this->createDefaultImage("products/{$product->id}", $product);
        }
      }

      // se crea la imagen en el HD.
      if (!$result = $this->createFile($file, "products/{$product->id}")) return false;

      // se crea el modelo.
      $this->createImageModel($result, $product);
    endforeach;

    return true;
  }

  /**
   * crea la imagen relacionada con algun feature.
   *
   * @param UploadedFile  $file    Objeto UploadedFiles con la imagen.
   * @param Product       $product El modelo de producto.
   * @param Feature       $feature El modelo de feature relacionado con producto.
   *
   * @return boolean
   */
  public function createFeatureImage(\Symfony\Component\HttpFoundation\File\UploadedFile $file, Product $product, Feature $feature)
  {
    // el validador
    $validator = \Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails())
    {
      // si las imagen no es valida crea una imagen por defecto
      return $this->createDefaultImage("products/{$product->id}", $feature);
    }

    // se crea la imagen en el HD.
    if (!$result = $this->createFile($file, "products/{$product->id}")) return false;

    // se crea el modelo.
    $this->createImageModel($result, $feature);

    return true;
  }

  /**
   * crea la imagen relacionada con algun rubro.
   *
   * @param UploadedFile  $file    Objeto UploadedFiles con la imagen.
   * @param SubCategory   $subCat  El modelo del rubro.
   * @param Feature       $feature El modelo de feature relacionado con producto.
   *
   * @return boolean
   */
  public function createSubCategoryImage(\Symfony\Component\HttpFoundation\File\UploadedFile $file, SubCategory $subCat)
  {
    // el validador
    $validator = \Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails())
    {
      // si las imagen no es valida
      // TODO: mejorar
      return false;
    }

    // se crea la imagen en el HD.
    if (!$result = $this->createFile($file, "sub-category/{$subCat->id}")) return false;

    // se crea el modelo.
    $this->createImageModel($result, $subCat);

    return true;
  }

  /**
   * crea la imagen por defecto relacionada con algun producto.
   *
   * @param string $path  La direccion a donde se guardara
   * @param object $model El modelo relacionado para ser asociado.
   *
   * @return boolean
   */
  public function createDefaultImage($path, $model)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);
    $path = "{$path}/{$name}.gif";
    // se copia el archivo
    if (\Storage::disk('public')->copy('sin_imagen.gif', $path)) :

      // la data necesaria para crear el modelo de imagen.
      $data = [
        'path' => $path,
        'mime' => 'image/gif'
      ];

      return $this->createImageModel($data, $model);

    endif;

    return false;

  }

  /**
   * actualiza la imagen relacionada con algun feature.
   *
   * @param UploadedFile  $file    Objeto UploadedFiles con la imagen.
   * @param Product       $product El modelo de producto.
   * @param Feature       $feature El modelo de feature relacionado con producto.
   *
   * @return boolean
   */
  public function updateFeatureImage(\Symfony\Component\HttpFoundation\File\UploadedFile $file, Product $product, Feature $feature)
  {
    // el validador
    $validator = \Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails()) return false;

    // si no existe modelo se crea uno y se ignora el bloque condicional
    if($feature->image):
      // se chequea si existe el archivo y se elimina
      if (\Storage::disk('public')->exists($feature->image->path))
        \Storage::disk('public')->delete($feature->image->path);

      // se crea la imagen en el HD y se actualiza el modelo.
      if (!$result = $this->createFile($file, "products/{$product->id}"))
        return $this->createDefaultImage("products/{$product->id}", $feature);

      return $feature->image->update($result);
    endif;

    // se crea la imagen en el HD.
    if (!$result = $this->createFile($file, "products/{$product->id}")) return false;

    // se crea el modelo.
    $this->createImageModel($result, $feature);

    return true;
  }

  /**
   * crea el modelo nuevo de alguna imagen relacionada con algun producto.
   *
   * @param array   $array   el array que contiene los datos para la imagen.
   * @param Product $product el modelo de producto.
   *
   * @return boolean
   */
  private function createImageModel(array $array, $model)
  {
    $image = new Image($array);
    $image->created_by = $this->userId;
    $image->updated_by = $this->userId;

    switch (get_class($model)) :

      case 'App\Product':
        $image->alt = $model->title;
        return $model->images()->save($image);

      case 'App\Feature':
        $image->alt = $model->title;
        return $model->image()->save($image);

      case 'App\Category':
        $image->alt = $model->description;
        return $model->image()->save($image);

      case 'App\SubCategory':
        $image->alt = $model->description;
        return $model->image()->save($image);

      default:
        throw new \Exception("Error: modelo desconocido, no se puede guardar imagen", 1);
        break;

    endswitch;
  }

  /**
   * usado para crear en el disco duro el archivo relacionado a un producto.
   *
   * @param  SymfonyComponentHttpFoundationFileUploadedFile $model
   * @param  string $path la direccion a donde se guardara el archivo.
   * @return array  $data la carpeta, nombre y extension del archivo guardado.
   */
  private function createFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file, $path = null)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);

    $ext = $file->getClientOriginalExtension();

    // i have no idea what im doing.
    try
    {
      $file->move($path, "{$name}.{$ext}");
    }
    catch(\FileException $e)
    {
      return false;
    }

    // la data necesaria para crear el modelo de imagen.
    $data = [
      'path' => "$path/{$name}.{$ext}",
      'mime' => $file->getClientMimeType()
    ];

    return $data;
  }

  private function generatePathFromModel($model)
  {
    switch (get_class($model)) :

      case 'App\Product':
        return "products/{$model->id}";

      case 'App\Feature':
        return "products/{$model->product->id}";

      case 'App\Category':
        return "category/{$model->id}";

      case 'App\SubCategory':
        return "sub-category/{$model->id}";

      default:
        throw new \Exception("Error: modelo desconocido, no se puede crear ruta", 2);
        break;

    endswitch;
  }
}
