<?php namespace App\Mamarrachismo;

use Auth;
use App\Product;
use App\Feature;
use App\SubCategory;
use App\Category;
use App\Image;

class Upload {

  /**
   * @var int
   */
  public $userId;

  /**
   * el modelo a ser manipulado
   *
   * @todo implementar.
   * @var object
   */
  public $model;

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
   * crea la(s) imagen(es) relacionadas con algun modelo.
   *
   * @param array  $array   El array con los objetos UploadedFiles.
   * @param object $product El modelo a relacionar con la imagen.
   *
   * @return boolean
   */
  public function createImages(array $array = null, $model)
  {
    $this->path = $this->generatePathFromModel($model);

    if(!$array) return $this->createDefaultImage($this->path, $model);

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
          return $this->createDefaultImage($this->path, $model);
        }
      }

      // se crea la imagen en el HD.
      if (!$result = $this->createFile($file, $this->path)) return false;

      // se crea el modelo.
      $this->createImageModel($result, $model);
    endforeach;

    return true;
  }

  /**
   * crea la imagen relacionada con algun modelo.
   *
   * @param UploadedFile  $file  Objeto UploadedFiles con la imagen.
   * @param object        $model El modelo relacionado para ser asociado.
   *
   * @return boolean
   */
  public function createImage(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null, $model)
  {
    $this->path = $this->generatePathFromModel($model);

    // el validador
    $validator = \Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails())
    {
      // si las imagen no es valida crea una imagen por defecto
      return $this->createDefaultImage($this->path, $model);
    }

    // se crea la imagen en el HD.
    if (!$result = $this->createFile($file, $this->path)) return false;

    // se crea el modelo.
    $this->createImageModel($result, $model);

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
   * @param UploadedFile  $file         Objeto UploadedFiles con la imagen.
   * @param object        $parentModel  El modelo a actualizar.
   * @param App\Image     $imageModel   El modelo de la imagen.
   *
   * @return boolean
   */
  public function updateImage(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null, $parentModel, Image $imageModel)
  {
    $this->path = $this->generatePathFromModel($parentModel);

    // el validador
    $validator = \Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails()) return false;

    // se chequea si existe el archivo y se elimina
    if (\Storage::disk('public')->exists($imageModel->path))
      \Storage::disk('public')->delete($imageModel->path);

    // se crea la imagen en el HD y se actualiza el modelo.
    if (!$result = $this->createFile($file, $this->path))
      return $this->createDefaultImage($this->path, $parentModel);

    return $imageModel->update($result);
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

      case 'App\Maker':
        $image->alt = $model->name;
        return $model->images()->save($image);

      case 'App\Promotion':
        $image->alt = $model->title;
        return $model->images()->save($image);

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
    catch(FileException $e)
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

      case 'App\Maker':
        return "makers/{$model->id}";

      case 'App\Promotion':
        return "promos/{$model->id}";

      default:
        throw new \Exception("Error: modelo desconocido, no se puede crear ruta", 2);
        break;

    endswitch;
  }
}
