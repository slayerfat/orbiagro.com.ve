<?php namespace App\Mamarrachismo\Upload;

use Exception;
use Validator;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Mamarrachismo\Upload\Upload;
use App\Image as Model;

class Image extends Upload {

  /**
   * crea la(s) imagen(es) relacionadas con algun modelo.
   *
   * @param array  $array  El array con los objetos UploadedFiles.
   * @param object $model  El modelo a relacionar con la imagen.
   *
   * @return \Illuminate\Support\Collection
   */
  public function createImages(array $array = null, $model)
  {
    $collection = collect();

    $this->path = $this->generatePathFromModel($model);

    if(!$array)
    {
      $collection = $collection->push($this->createDefaultImage($this->path, $model));

      return $collection;
    }

    foreach($array as $file)
    {
      // el validador
      $validator = Validator::make(['image' => $file], $this->imageRules);

      if ($validator->fails())
      {
        // si existe entre 0 y 1 en el array y la imagen es invalida
        // se crea la imagen por defecto
        if (sizeOf($array) <= 1)
        {
          // si las imagenes no son validas crea una imagen por defecto
          $collection = $collection->push($this->createDefaultImage($this->path, $model));

          return $collection;
        }

        $this->errors = $validator->errors()->all();

        throw new Exception("Error, Imagenes no validas.", 5);
      }

      // se crea la imagen en el HD.
      if (!$result = $this->makeFile($file, $this->path)) return $collection;

      // se crea el modelo.
      $collection = $collection->push($this->createImageModel($result, $model));
    }

    return $collection;
  }

  /**
   * crea la imagen relacionada con algun modelo.
   *
   * @param UploadedFile  $file  Objeto UploadedFiles con la imagen.
   * @param object        $model El modelo relacionado para ser asociado.
   *
   * @return \Illuminate\Support\Collection
   */
  public function createImage(UploadedFile $file = null, $model)
  {
    $result = $this->createImages([$file], $model);

    if ($result->isEmpty())
    {
      return $result;
    }

    return $result->first();
  }

  /**
   * crea la imagen por defecto relacionada con algun modelo.
   *
   * @param string $path  La direccion a donde se guardara
   * @param object $model El modelo relacionado para ser asociado.
   *
   * @return boolean
   */
  public function createDefaultImage($path = null, $model)
  {
    if ($path === null && isset($this->path))
    {
      $path = $this->path;
    }

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
   * @param App\Model     $imageModel   El modelo de la imagen.
   *
   * @return boolean
   */
  public function updateImage(UploadedFile $file = null, $parentModel, Model $imageModel = null)
  {
    if ($imageModel == null) return $this->createImage($file, $parentModel);

    $this->path = $this->generatePathFromModel($parentModel);

    // el validador
    $validator = Validator::make(['image' => $file], $this->imageRules);
    if (!$file || $validator->fails())
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

  /**
   * actualiza el archivo relacionado con algun modelo.
   *
   * @param UploadedFile  $file         Objeto UploadedFiles con la imagen.
   * @param object        $parentModel  El modelo a actualizar.
   * @param App\File      $fileModel    El modelo del archivo.
   *
   * @return boolean
   */
  public function updateFile(UploadedFile $file = null, $parentModel = null, File $fileModel = null)
  {
    if ($fileModel == null) return $this->createFile($file, $parentModel);

    $this->path = $this->generatePathFromModel($parentModel);

    // el validador
    $validator = Validator::make(['file' => $file], $this->fileRules);
    if (!$file || $validator->fails())
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
   * @return \Illuminate\Database\Eloquent\Model
   */
  private function createImageModel(array $array, $model)
  {
    $image = new Model($array);

    // si la aplicacion esta por consola (artisan u otro)
    // se le asigna el created/updated by.
    if (app()->runningInConsole())
    {
      $image->created_by = $this->userId;
      $image->updated_by = $this->userId;
    }

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

    endswitch;
  }
}
