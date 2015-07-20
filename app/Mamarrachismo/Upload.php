<?php namespace App\Mamarrachismo;

use Exception;
use Validator;
use Storage;

use Auth;
use App\Product;
use App\Feature;
use App\SubCategory;
use App\Category;
use App\Image;
use App\File;

class Upload {

  /**
   * @var mixed
   */
  public $errors;

  /**
   * @var int
   */
  public $userId;

  /**
   * el modelo a ser manipulado
   *
   * @var Object
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

  /**
   * reglas para el validador.
   * @var array
   */
  private $fileRules = ['file' => 'mimes:pdf|max:10000'];

  public function __construct($userID = null)
  {
    $this->userId = $userID;
  }

  // --------------------------------------------------------------------------
  // Funciones Publicas
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Imagenes
  // --------------------------------------------------------------------------

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
      $validator = Validator::make(['image' => $file], $this->imageRules);
      if ($validator->fails())
      {
        // si existe entre 0 y 1 en el array y la imagen es invalida
        // se crea la imagen por defecto
        if (sizeOf($array) <= 1)
        {
          // si las imagenes no son validas crea una imagen por defecto
          return $this->createDefaultImage($this->path, $model);
        }
        $this->errors = $validator->errors()->all();
        throw new Exception("Error, Imagenes no validas.", 5);
      }

      // se crea la imagen en el HD.
      if (!$result = $this->makeFile($file, $this->path)) return false;

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
    $validator = Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails())
    {
      // si las imagen no es valida crea una imagen por defecto
      return $this->createDefaultImage($this->path, $model);
    }

    // se crea la imagen en el HD.
    if (!$result = $this->makeFile($file, $this->path)) return false;

    // se crea el modelo.
    $this->createImageModel($result, $model);

    return true;
  }

  /**
   * crea la imagen por defecto relacionada con algun modelo.
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
    if (Storage::disk('public')->copy('sin_imagen.gif', $path)) :

      // la data necesaria para crear el modelo de imagen.
      $data = [
        'path' => $path,
        'mime' => 'image/gif'
      ];

      return $this->createImageModel($data, $model);

    endif;

    throw new \Exception("Error, Imagen por defecto no puede ser creada", 4);
  }

  /**
   * actualiza la imagen relacionada con algun modelo.
   *
   * @param UploadedFile  $file         Objeto UploadedFiles con la imagen.
   * @param object        $parentModel  El modelo a actualizar.
   * @param App\Image     $imageModel   El modelo de la imagen.
   *
   * @return boolean
   */
  public function updateImage(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null, $parentModel, Image $imageModel = null)
  {
    if ($imageModel == null) return $this->createImage($file, $parentModel);

    $this->path = $this->generatePathFromModel($parentModel);

    // el validador
    $validator = Validator::make(['image' => $file], $this->imageRules);
    if ($validator->fails())
    {
      $this->errors = $validator->errors()->all();
      throw new Exception("Error, archivo no valido", 3);
    }
    // se chequea si existe el archivo y se elimina
    if (Storage::disk('public')->exists($imageModel->path))
      Storage::disk('public')->delete($imageModel->path);

    // se crea la imagen en el HD y se actualiza el modelo.
    if (!$result = $this->makeFile($file, $this->path))
      return $this->createDefaultImage($this->path, $parentModel);

    return $imageModel->update($result);
  }

  // --------------------------------------------------------------------------
  // Archivos
  // --------------------------------------------------------------------------

  /**
   * crea la imagen relacionada con algun modelo.
   *
   * @param UploadedFile  $file  Objeto UploadedFiles con la imagen.
   * @param object        $model El modelo relacionado para ser asociado.
   *
   * @return boolean
   */
  public function createFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null, $model)
  {
    $this->path = $this->generatePathFromModel($model);

    // el validador
    $validator = Validator::make(['file' => $file], $this->fileRules);
    if ($validator->fails())
    {
      $this->errors = $validator->errors()->all();
      throw new Exception("Error, archivo no valido", 3);
    }

    // se crea el archivo en el HD.
    if (!$result = $this->makeFile($file, $this->path)) return false;

    // se crea el modelo.
    $this->createFileModel($result, $model);

    return true;
  }

  /**
   * actualiza el archivo relacionado con algun modelo.
   *
   * @param UploadedFile  $file         Objeto UploadedFiles con la imagen.
   * @param object        $parentModel  El modelo a actualizar.
   * @param App\File      $fileModel    El modelo del archivo.
   *
   * @return boolean
   */
  public function updateFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null, $parentModel = null, File $fileModel = null)
  {
    if ($fileModel == null) return $this->createFile($file, $parentModel);

    $this->path = $this->generatePathFromModel($parentModel);

    // el validador
    $validator = Validator::make(['file' => $file], $this->fileRules);
    if ($validator->fails())
    {
      $this->errors = $validator;
      throw new Exception("Error, archivo no valido", 3);
    }

    // se chequea si existe el archivo y se elimina
    if (Storage::disk('public')->exists($fileModel->path))
      Storage::disk('public')->delete($fileModel->path);

    // se crea la imagen en el HD y se actualiza el modelo.
    if ($result = $this->makeFile($file, $this->path))
      return $fileModel->update($result);
  }

  // --------------------------------------------------------------------------
  // Funciones Privadas
  // --------------------------------------------------------------------------

  /**
   * crea el modelo nuevo de alguna imagen relacionada con algun producto.
   *
   * @param array  $array el array que contiene los datos para la imagen.
   * @param Object $model el modelo a asociar.
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
      case 'App\Promotion':
        $image->alt = $model->title;
        return $model->images()->save($image);

      case 'App\Feature':
        $image->alt = $model->title;
        return $model->image()->save($image);

      case 'App\Category':
      case 'App\SubCategory':
        $image->alt = $model->description;
        return $model->image()->save($image);

      case 'App\Maker':
        $image->alt = $model->name;
        return $model->image()->save($image);

      default:
        throw new Exception("Error: modelo desconocido, no se puede guardar imagen", 1);
        break;

    endswitch;
  }

  /**
   * crea el modelo nuevo de alguna imagen relacionada con algun producto.
   *
   * @param array  $array el array que contiene los datos para la imagen.
   * @param Object $model el modelo a asociar.
   * @param File   $file  dependencia.
   *
   * @return boolean
   */
  private function createFileModel(array $array, $model)
  {
    $file = new File($array);
    $file->created_by = $this->userId;
    $file->updated_by = $this->userId;

    switch (get_class($model)) :

      case 'App\Product':
        return $model->files()->save($file);

      case 'App\Feature':
        return $model->file()->save($file);

      default:
        throw new Exception("Error: modelo desconocido, no se puede guardar archivo relacionado", 1);
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
  private function makeFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file, $path = null)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);

    $ext = $file->getClientOriginalExtension();

    $file->move($path, "{$name}.{$ext}");

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
        throw new Exception("Error: modelo desconocido, no se puede crear ruta, modelo vardump: "
          .var_dump($model)." typeof modelo ".gettype($model), 2);
        break;

    endswitch;
  }
}
