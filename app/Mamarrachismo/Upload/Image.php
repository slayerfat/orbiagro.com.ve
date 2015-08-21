<?php namespace App\Mamarrachismo\Upload;

use Exception;
use Validator;
use Storage;
use Intervention;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Mamarrachismo\Upload\Upload;
use App\Image as Model;

class Image extends Upload
{

    /**
    * crea la(s) imagen(es) relacionadas con algun modelo.
    *
    * @param object $model  El modelo a relacionar con la imagen.
    * @param array  $array  El array con los objetos UploadedFiles.
    *
    * @return \Illuminate\Support\Collection
    */
    public function createImages($model, array $array = null)
    {
        $collection = collect();

        $this->path = $this->generatePathFromModel($model);

        if (!$array) {
            $collection = $collection->push($this->createDefaultImage($model, $this->path));

            return $collection;
        }

        foreach ($array as $file) {
            // el validador
            $validator = Validator::make(['image' => $file], $this->imageRules);

            if ($validator->fails()) {
                // si existe entre 0 y 1 en el array y la imagen es invalida
                // se crea la imagen por defecto
                if (sizeOf($array) <= 1) {
                    // si las imagenes no son validas crea una imagen por defecto
                    $collection = $collection->push($this->createDefaultImage($model, $this->path));

                    return $collection;
                }

                $this->errors = $validator->errors()->all();

                throw new Exception("Error, Imagenes no validas.", 5);
            }

            // se crea la imagen en el HD.
            if (!$result = $this->makeImageFile($file, $this->path)) {
                return $collection;
            }

            // se crea el modelo.
            $collection = $collection->push($this->createImageModel($result, $model));
        }

        return $collection;
    }

    /**
    * crea la imagen relacionada con algun modelo.
    *
    * @param object        $model El modelo relacionado para ser asociado.
    * @param UploadedFile  $file  Objeto UploadedFiles con la imagen.
    *
    * @return \Illuminate\Support\Collection
    */
    public function createImage($model, UploadedFile $file = null)
    {
        $result = $this->createImages($model, [$file]);

        if ($result->isEmpty()) {
            return $result;
        }

        return $result->first();
    }

    /**
    * crea la imagen por defecto relacionada con algun modelo.
    *
    * @param object $model      El modelo relacionado para ser asociado.
    * @param string $modelPath  La direccion a donde se guardara
    *
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function createDefaultImage($model, $modelPath = null)
    {
        if ($modelPath === null && isset($this->path)) {
            $modelPath = $this->path;
        }

        // el nombre del archivo
        $name = date('Ymdhmmss-').str_random(20);
        $path = "{$modelPath}/{$name}.gif";

        // se copia el archivo
        if (!Storage::disk('public')->copy('sin_imagen.gif', $path)) {
            throw new \Exception("Error, Imagen por defecto no puede ser creada", 4);
        }

        // la data necesaria para crear el modelo de imagen.
        $data = [
            'name' => $name,
            'ext'  => 'gif',
            'dir'  => $modelPath,
            'path' => $path,
            'mime' => 'image/gif'
        ];

        $data = $this->makeOriginalFile($data);

        // para seeding y otros:
        unset($data['name'], $data['ext'], $data['dir']);

        return $this->createImageModel($data, $model);
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
        if ($imageModel == null) {
            return $this->createImage($parentModel, $file);
        }

        $this->path = $this->generatePathFromModel($parentModel);

        // el validador
        $validator = Validator::make(['image' => $file], $this->imageRules);

        if (!isset($file) || $validator->fails()) {
            $this->errors = $validator->errors()->all();

            throw new Exception("Error, archivo no valido", 3);
        }

        // verdadero porque se eliminan TODOS los archivos
        $this->deleteImageFiles($imageModel, true);

        // se crea la imagen en el HD y se actualiza el modelo.
        if (!$result = $this->makeImageFile($file, $this->path, $options)) {
            return $this->createDefaultImage($parentModel, $this->path);
        }

        return $imageModel->update($result);
    }

    /**
     * @param  Model $image  la imagen.
     * @param  int   $width
     * @param  int   $height
     * @param  int   $posX
     * @param  int   $posY
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function cropImage(Model $image, $width, $height, $posX = null, $posY = null)
    {
        // se crea el objeto con el archivo real en el disco duro
        $updatedImage = Intervention::make($image->original);

        // http://image.intervention.io/api/crop
        $updatedImage->crop($width, $height, $posX, $posY);

        // se guarda el archivo
        $updatedImage->save(public_path($image->path));

        // falso porque no se eliminan TODOS los archivos
        $this->deleteImageFiles($image, false);

        $data = ['dir' => $this->generatePathFromModel($image->imageable)];

        $result = $this->createSmallMediumLargeFiles($updatedImage, $data);

        return $image->update($result);
    }

    /**
    * elimina todas las imagenes del disco duro.
    *
    * @param App\Image  $imageModel El modelo de la imagen.
    * @param boolean    $all        para determinar si se elimina del disco duro TODOS los archivos.
    *
    * @return void
    */
    public function deleteImageFiles($imageModel, $all)
    {
        $this->errors = [];

        $attributes = ['small', 'medium', 'large'];

        if ($all === true) {
            $attributes[] = 'original';
            $attributes[] = 'path';
        }

        // se chequea si existe el archivo y se elimina
        foreach ($attributes as $attribute) {
            if ($imageModel->$attribute !== null && trim($imageModel->$attribute) != '') {
                try {
                    Storage::disk('public')->delete($imageModel->$attribute);
                } catch (Exception $e) {
                    $this->errors['imageModel'] = $imageModel;
                    $this->errors['all'] = $all;
                    $this->errors['attributes'] = $attributes;
                    $this->errors["deleteImage: $attribute"] = $e;
                }
            }
        }
    }

    // --------------------------------------------------------------------------
    // Funciones Privadas
    // --------------------------------------------------------------------------

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

        $data = $this->makeOriginalFile($data);

        $image = Intervention::make($data['path']);

        $result = $this->createSmallMediumLargeFiles($image, $data);

        $data = $data + $result;

        if (!$options) {
            return $data;
        }

        // Intervention
        foreach ($options as $method => $parameters) {
            dd($image);

            $image->$method($parameters); //etc...
        }

        return $data;
    }

    /**
    * crea la imagen no modificada asociada al modelo.
    *
    * @param  array  $data la informacion relacionada con la imagen a crear.
    * @return array
    */
    private function makeOriginalFile(array $data)
    {
        if (!Storage::disk('public')->exists($data['path'])) {
            throw new Exception('No existe archivo asociado en el disco.', 2);
        }

        $data['original'] = $data['dir'].'/o-'.$data['name'].'.'.$data['ext'];

        $image = Intervention::make(public_path($data['path']))->save(public_path($data['original']));

        $result = $this->createSmallMediumLargeFiles($image, $data);

        return $data + $result;
    }

    /**
    * crea los archivos de diferentes tamaños relacionados con alguna imagen.
    *
    * @param  \Intervention\Image\Image  $image la instancia de la imagen relacionada.
    * @param  array                      $data  los datos relacionados, por ahora
    *                                           solo se necesita la direccion del
    *                                           modelo (producto/id).
    * @return array
    */
    private function createSmallMediumLargeFiles(Intervention\Image\Image $image, array $data)
    {
        if (!isset($data['dir'])) {
            throw new Exception('Error: no hay informacion sobre el directorio relacionado.', 6);
        }

        // datos de la imagen
        $dir          = $image->dirname;
        $filename     = $image->filename;
        $ext          = $image->extension;
        $originalPath = $dir.'/'.$image->basename;

        // datos para relacionar con el modelo
        $data = [
            'small'  => $data['dir'].'/s-'.$filename.'.'.$ext,
            'medium' => $data['dir'].'/m-'.$filename.'.'.$ext,
            'large'  => $data['dir'].'/l-'.$filename.'.'.$ext,
        ];

        // para el foreach
        $sizes = [
            128  => $data['small'],
            512  => $data['medium'],
            1024 => $data['large']
        ];

        foreach ($sizes as $size => $path) {
            // se crea una instancia cada vez que inicia el ciclo
            // para modificar la imagen original y no el resultado de la operacion
            $image = Intervention::make($originalPath);

            $image->fit($size)->save(public_path($path));
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
        if (app()->runningInConsole()) {
            $image->created_by = $this->userId;
            $image->updated_by = $this->userId;
        }

        switch (get_class($model)) {
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

        }
    }
}
