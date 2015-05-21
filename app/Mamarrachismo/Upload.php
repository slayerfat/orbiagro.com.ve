<?php namespace App\Mamarrachismo;

use Auth;
use App\Product;
use App\Image;

/**
 *
 */
class Upload {

  public $userId;

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
      // reglas para el validador.
      $rules = ['image' => 'required|mimes:jpeg,bmp,png|max:10000'];

      // el validador
      $validator = \Validator::make(['image' => $file], $rules);
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
      $this->createImageModel($result, $product);
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
    // se copia el archivo
    if (\Storage::disk('public')->copy('sin_imagen.gif', "products/{$product->id}/sin_imagen.gif")) :

      $image = new Image;
      $image->path       = "products/{$product->id}/sin_imagen.gif";
      $image->mime       = 'image/gif';
      $image->alt        = $product->title;
      $image->created_by = $this->userId;
      $image->updated_by = $this->userId;

      return $product->images()->save($image);

    endif;

    return false;

  }

  /**
   * crea el modelo nuevo de alguna imagen relacionada con algun producto.
   *
   * @param array   $array   el array que contiene los datos para la imagen.
   * @param Product $product el modelo de producto.
   *
   * @return boolean
   */
  private function createImageModel(array $array, Product $product)
  {
    $image = new Image($array);
    $image->created_by = $this->userId;
    $image->updated_by = $this->userId;
    $image->alt = $product->title;
    return $product->images()->save($image);
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