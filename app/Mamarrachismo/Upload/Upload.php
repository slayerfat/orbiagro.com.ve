<?php namespace App\Mamarrachismo\Upload;

use Exception;
use Validator;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
  protected $path;

  /**
   * reglas para el validador.
   * @var array
   */
  protected $imageRules = ['image' => 'required|mimes:jpeg,bmp,png|max:10000'];

  /**
   * reglas para el validador.
   * @var array
   */
  protected $fileRules = ['file' => 'mimes:pdf|max:10000'];

  public function __construct($userID = null)
  {
    if ($userID !== null)
    {
      $this->userId = $userID;
    }
  }

  /**
   * usado para crear en el disco duro el archivo relacionado a un producto.
   *
   * @param  UploadedFile $file
   * @param  string $path la direccion a donde se guardara el archivo.
   *
   * @return array  $data la carpeta, nombre y extension del archivo guardado.
   */
  protected function makeFile(UploadedFile $file, $path = null)
  {
    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);

    $ext = $file->getClientOriginalExtension();

    $file->move($path, "{$name}.{$ext}");

    // la data necesaria para crear el modelo de imagen.
    $data = [
      'name' => $name,
      'ext'  => $ext,
      'dir'  => $path,
      'path' => "$path/{$name}.{$ext}",
      'mime' => $file->getClientMimeType()
    ];

    return $data;
  }

  protected function generatePathFromModel($model)
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
        throw new Exception("Error: modelo desconocido, no se puede crear ruta, modelo ".gettype($model), 2);

    endswitch;
  }
}
