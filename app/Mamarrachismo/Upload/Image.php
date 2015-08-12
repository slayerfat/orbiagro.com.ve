<?php namespace App\Mamarrachismo\Upload;

use Exception;
use Validator;
use Storage;
use Intervention;
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
      if (!$result = $this->makeImageFile($file, $this->path)) return $collection;

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
   * @return \Illuminate\Database\Eloquent\Model
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
   * @param UploadedFile  $file       Objeto UploadedFiles con la imagen.
   * @param App\Image     $imageModel El modelo de la imagen.
   * @param array         $options    las opcions relacionadas con Intervention.
   *
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function updateImage(UploadedFile $file = null, Model $imageModel = null, array $options = null)
  {
    $parentModel = $imageModel->imageable;

    // si no hay algun modelo relacionado, se crea uno de cero.
    if ($imageModel == null) return $this->createImage($file, $parentModel);

    $this->path = $this->generatePathFromModel($parentModel);

    // el validador
    $validator = Validator::make(['image' => $file], $this->imageRules);

    if (!isset($file) || $validator->fails())
    {
      $this->errors = $validator->errors()->all();
      throw new Exception("Error, archivo no valido", 3);
    }

    // verdadero porque se eliminan TODOS los archivos
    $this->deleteImageFiles($imageModel, true);

    // se crea la imagen en el HD y se actualiza el modelo.
    if (!$result = $this->makeImageFile($file, $this->path, $options))
      return $this->createDefaultImage($this->path, $parentModel);

    return $imageModel->update($result);
  }

  public function cropImage(Model $image, $width, $height, $posX = null, $posY = null)
  {
    // se crea el objeto con el archivo real en el disco duro
    $updatedImage = Intervention::make($image->original);

    // http://image.intervention.io/api/crop
    $updatedImage->crop($width, $height, $posX, $posY);

    // se guarda el archivo
    $updatedImage->save($image->path);

    // falso porque no se eliminan TODOS los archivos
    $this->deleteImageFiles($image, false);

    $result = $this->createSmallMediumLargeFiles($updatedImage);

    return $image->update($result);
  }

  // --------------------------------------------------------------------------
  // Funciones Privadas
  // --------------------------------------------------------------------------

  /**
   * elimina todas las imagenes del disco duro
   * @param App\Image     $imageModel El modelo de la imagen.
   *
   * @return void
   */
  private function deleteImageFiles($imageModel, $all)
  {
    $this->errors = [];

    $attributes = ['small', 'medium', 'large'];

    if ($all === true)
    {
      $attributes[] = 'original';
      $attributes[] = 'path';
    }

    // se chequea si existe el archivo y se elimina
    foreach ($attributes as $attribute)
    {
      if ($imageModel->$attribute !== null && trim($imageModel->$attribute) != '')
      {
        try
        {
          Storage::disk('public')->delete($imageModel->$attribute);
        }
        catch (Exception $e)
        {
          $this->errors['imageModel'] = $imageModel;
          $this->errors['all'] = $all;
          $this->errors['attributes'] = $attributes;
          $this->errors["deleteImage: $attribute"] = $e;
        }
      }
    }
  }
  /**
   * usado para crear en el disco duro el archivo relacionado a un producto.
   *
   * @param  UploadedFile $file
   * @param  string       $path     la direccion a donde se guardara el archivo.
   * @param  array        $options  las opcions relacionadas con Intervention.
   *
   * @return array        $data     la carpeta, nombre y
   *                                extension del archivo guardado.
   */
  private function makeImageFile(UploadedFile $file, $path = null, array $options = null)
  {
    $data = parent::makeFile($file, $path);

    $data['original'] = $data['dir'].'/o-'.$data['name'].'.'.$data['ext'];

    Intervention::make($data['path'])->save($data['original']);

    $image = Intervention::make($data['path']);

    $result = $this->createSmallMediumLargeFiles($image);

    $data = $data + $result;

    if (!$options)
    {
      return $data;
    }

    // Intervention
    foreach ($options as $method => $parameters)
    {
      dd($image);

      $image->$method($parameters); //etc...
    }

    return $data;
  }

  private function createSmallMediumLargeFiles(Intervention\Image\Image $image)
  {
    $dir          = $image->dirname;
    $filename     = $image->filename;
    $ext          = $image->extension;
    $originalPath = $dir.'/'.$image->basename;

    $data = [
      'small'  => $dir.'/s-'.$filename.'.'.$ext,
      'medium' => $dir.'/m-'.$filename.'.'.$ext,
      'large'  => $dir.'/l-'.$filename.'.'.$ext,
    ];

    $sizes = [
      128  => $data['small'],
      512  => $data['medium'],
      1024 => $data['large']
    ];

    foreach ($sizes as $size => $path)
    {
      $image = Intervention::make($originalPath);

      $image->resize($size, null, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
      })->save($path);
    }

    return $data;
  }

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
