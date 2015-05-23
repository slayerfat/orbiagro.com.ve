<?php namespace App\Mamarrachismo;

use Auth;
use App\Product;
use App\Feature;
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
          return $this->createDefaultProductImage($product);
        }
      }

      // se crea la imagen en el HD.
      if (!$result = $this->createFile($file, $product)) return false;

      // se crea el modelo.
      $this->createProductImageModel($result, $product);
    endforeach;

    return true;
  }

  /**
   * crea la imagen por defecto relacionada con algun producto.
   *
   * @param Product $product El modelo de producto.
   *
   * @return boolean
   */
  public function createDefaultProductImage(Product $product)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);
    $path = "products/{$product->id}/{$name}.gif";
    // se copia el archivo
    if (\Storage::disk('public')->copy('sin_imagen.gif', $path)) :

      $image = new Image;
      $image->path       = $path;
      $image->mime       = 'image/gif';
      $image->alt        = $product->title;
      $image->created_by = $this->userId;
      $image->updated_by = $this->userId;

      return $product->images()->save($image);

    endif;

    return false;

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
      return $this->createDefaultFeatureImage($product, $feature);
    }

    // se crea la imagen en el HD.
    if (!$result = $this->createFile($file, $product)) return false;

    // se crea el modelo.
    $this->createFeatureImageModel($result, $feature);

    return true;
  }

  /**
   * crea la imagen por defecto relacionada con algun producto.
   *
   * @param Product $product El modelo de producto.
   * @param Feature $feature El modelo de feature relacionado con producto.
   *
   * @return boolean
   */
  public function createDefaultFeatureImage(Product $product, Feature $feature)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);
    $path = "products/{$product->id}/{$name}.gif";
    // se copia el archivo
    if (\Storage::disk('public')->copy('sin_imagen.gif', $path)) :

      $image = new Image;
      $image->path       = $path;
      $image->mime       = 'image/gif';
      $image->alt        = $feature->title;
      $image->created_by = $this->userId;
      $image->updated_by = $this->userId;

      return $feature->image()->save($image);

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
      if (!$result = $this->createFile($file, $product))
        return $this->createDefaultFeatureImage($product, $feature);

      return $feature->image->update($result);
    endif;

    // se crea la imagen en el HD.
    if (!$result = $this->createFile($file, $product)) return false;

    // se crea el modelo.
    $this->createFeatureImageModel($result, $feature);

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
  private function createProductImageModel(array $array, Product $product)
  {
    $image = new Image($array);
    $image->created_by = $this->userId;
    $image->updated_by = $this->userId;
    $image->alt = $product->title;
    return $product->images()->save($image);
  }

  /**
   * crea el modelo nuevo de alguna imagen relacionada con algun feature.
   *
   * @param array   $array   el array que contiene los datos para la imagen.
   * @param Feature $feature el modelo de feature.
   *
   * @return boolean
   */
  private function createFeatureImageModel(array $array, Feature $feature)
  {
    $image = new Image($array);
    $image->created_by = $this->userId;
    $image->updated_by = $this->userId;
    $image->alt = $feature->title;
    return $feature->image()->save($image);
  }

  /**
   * usado para crear en el disco duro el archivo relacionado a un producto.
   *
   * @param  SymfonyComponentHttpFoundationFileUploadedFile $model
   * @param  Product $product el modelo de producto.
   * @return array   $data    la carpeta, nombre y extension del archivo guardado.
   */
  private function createFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file, Product $product)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);

    $ext = $file->getClientOriginalExtension();

    // i have no idea what im doing.
    try
    {
      $file->move("products/{$product->id}", "{$name}.{$ext}");
    }
    catch(\FileException $e)
    {
      return false;
    }

    // la data necesaria para crear el modelo de imagen.
    $data = [
      'path' => "products/{$product->id}/{$name}.{$ext}",
      'mime' => $file->getClientMimeType()
    ];

    return $data;
  }
}
