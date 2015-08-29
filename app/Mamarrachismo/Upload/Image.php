<?php namespace Orbiagro\Mamarrachismo\Upload;

use Exception;
use Log;
use LogicException;
use Orbiagro\Mamarrachismo\Upload\Exceptions\OrphanImageException;
use Orbiagro\Repositories\Exceptions\DefaultImageFileNotFoundException;
use Validator;
use Storage;
use Intervention;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Image as ImageModel;

class Image extends Upload
{

    /**
     * crea la(s) imagen(es) relacionadas con algun modelo.
     *
     * @param Model $model El modelo a relacionar con la imagen.
     * @param array $array El array con los objetos UploadedFiles.
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function createImages(Model $model, array $array = null)
    {
        $collection = collect();

        $this->path = $this->generatePathFromModel($model);

        if (!$array) {
            $collection->push($this->createDefaultImage($model, $this->path));

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
                    $collection->push($this->createDefaultImage($model, $this->path));

                    return $collection;
                }

                $this->errors = $validator->errors()->all();

                throw new Exception('Imagenes no validas.');
            }

            // se crea la imagen en el HD.
            if (!$result = $this->makeImageFile($file, $this->path)) {
                return $collection;
            }

            // se crea el modelo.
            $collection->push($this->createImageModel($result, $model));
        }

        return $collection;
    }

    /**
     * crea la imagen relacionada con algun modelo.
     *
     * @param Model        $model El modelo relacionado para ser asociado.
     * @param UploadedFile $file  Objeto UploadedFiles con la imagen.
     *
     * @return \Illuminate\Support\Collection
     */
    public function create(Model $model, UploadedFile $file = null)
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
     * @param Model $model El modelo relacionado para ser asociado.
     * @param string $modelPath La direccion a donde se guardara
     * @return Model
     * @throws Exception
     */
    public function createDefaultImage(Model $model, $modelPath = null)
    {
        $modelPath = $this->getModelPath($model, $modelPath);

        $this->checkModelImage($model);

        // el nombre del archivo
        $name = date('Ymdhmmss-').str_random(20);
        $path = "{$modelPath}/{$name}.gif";

        // se copia el archivo
        if (!Storage::disk('public')->copy('sin_imagen.gif', $path)) {
            throw new DefaultImageFileNotFoundException('Imagen por defecto no puede ser creada.');
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
     * @param Model $model El modelo de la imagen.
     * @param UploadedFile $file Objeto UploadedFiles con la imagen.
     * @param array $options las opcions relacionadas con Intervention.
     * @return Model
     * @throws Exception
     */
    public function update(Model $model, UploadedFile $file = null, array $options = null)
    {
        if (!$model instanceof ImageModel) {
            $this->checkModelImage($model);

            return $this->createDefaultImage($model);
        }

        /** @var Model $parentModel */
        $parentModel = $model->imageable;

        if ($parentModel == null) {
            throw new OrphanImageException(
                'La imagen con id: '.$model->id
                .' no posee padre.',
                $model->id
            );
        }

        $this->path = $this->generatePathFromModel($parentModel);

        // el validador
        $validator = Validator::make(['image' => $file], $this->imageRules);

        if (!isset($file) || $validator->fails()) {
            $this->errors = $validator->errors()->all();

            throw new Exception('Archivo no valido.');
        }

        // verdadero porque se eliminan TODOS los archivos
        $this->deleteImageFiles($model, true);

        // se crea la imagen en el HD y se actualiza el modelo.
        if (!$result = $this->makeImageFile($file, $this->path, $options)) {
            return $this->createDefaultImage($parentModel, $this->path);
        }

        $model->update($result);

        return $model;
    }

    /**
     * Cropea la imagen y la persiste en la BD.
     * @param  Model $image  la imagen.
     * @param  int   $width
     * @param  int   $height
     * @param  int   $posX
     * @param  int   $posY
     *
     * @return bool
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
     * @param ImageModel   $imageModel El modelo de la imagen.
     * @param boolean $all        para determinar si se elimina del disco duro TODOS los archivos.
     *
     * @return void
     */
    public function deleteImageFiles($imageModel, $all)
    {
        $paths = [
            $imageModel->small,
            $imageModel->medium,
            $imageModel->large
        ];

        if ($all === true) {
            $paths[] = $imageModel->path;
            $paths[] = $imageModel->original;
        }

        foreach ($paths as $path) {
            if (!Storage::disk('public')->exists($path)) {
                Log::alert(
                    'Se intento eliminar una imagen que no existe en el disco duro.',
                    [
                        'image_id'       => $imageModel->id,
                        'imageable_id'   => $imageModel->imageable_id,
                        'imageable_type' => $imageModel->imageable_type,
                        'user' => \Auth::user()
                    ]
                );

                continue;
            }

            Storage::disk('public')->delete($path);
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

        if (!$options) {
            return $data;
        }

        $image = Intervention::make($data['path']);

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
     * @param  array $data la informacion relacionada con la imagen a crear.
     * @return array
     * @throws LogicException
     */
    private function makeOriginalFile(array $data)
    {
        if (!Storage::disk('public')->exists($data['path'])) {
            throw new LogicException('No existe archivo asociado en el disco.');
        }

        $data['original'] = $data['dir'].'/o-'.$data['name'].'.'.$data['ext'];

        Intervention::make(public_path($data['path']))->save(public_path($data['original']));

        $image = Intervention::make(public_path($data['original']));

        $result = $this->createSmallMediumLargeFiles($image, $data);

        return $data + $result;
    }

    /**
     * crea los archivos de diferentes tamaños relacionados con alguna imagen.
     *
     * @param  \Intervention\Image\Image $image la instancia de la imagen relacionada.
     * @param  array $data los datos relacionados, por ahora
     *                     solo se necesita la direccion del
     *                     modelo (producto/id).
     * @return array
     * @throws LogicException
     */
    private function createSmallMediumLargeFiles(Intervention\Image\Image $image, array $data)
    {
        if (!isset($data['dir'])) {
            throw new LogicException('Error: no hay informacion sobre el directorio relacionado.', 6);
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

        Log::debug('Creando imagenes s-m-l relaciondas con una nueva imagen!', ['data' => $data]);

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
     * @param array $array el array que contiene los datos para la imagen.
     * @param Model $model el modelo a asociar.
     * @return Model
     * @throws Exception
     */
    private function createImageModel(array $array, Model $model)
    {
        $image = new ImageModel($array);

        // si la aplicacion esta por consola (artisan u otro)
        // se le asigna el created/updated by.
        if (app()->runningInConsole()) {
            $image->created_by = $this->userId;
            $image->updated_by = $this->userId;
        }

        switch (get_class($model)) {
            case 'Orbiagro\Models\Product':
            case 'Orbiagro\Models\Promotion':
                $image->alt = $model->title;
                return $model->images()->save($image);

            case 'Orbiagro\Models\Feature':
                $image->alt = $model->title;
                return $model->image()->save($image);

            case 'Orbiagro\Models\Category':
            case 'Orbiagro\Models\SubCategory':
                $image->alt = $model->description;
                return $model->image()->save($image);

            case 'Orbiagro\Models\Maker':
                $image->alt = $model->name;
                return $model->image()->save($image);

            default:
                throw new Exception(
                    'Modelo '
                    .get_class($model)
                    .'desconocido, no se puede guardar imagen.'
                );
        }
    }

    /**
     * Obtiene la direccion para generar alguna imagen.
     * @param Model $model
     * @param $modelPath
     * @return string
     */
    private function getModelPath(Model $model, $modelPath)
    {
        if ($modelPath === null && isset($this->path)) {
            return $this->path;
        } elseif (!isset($this->path)) {
            return $this->path = $this->generatePathFromModel($model);
        }

        throw new LogicException('No se puede obtener path para generar Imagen.');
    }

    /**
     * Elimina la imagen en la base de datos.
     * @param Model $model
     */
    private function checkModelImage(Model $model)
    {
        if ($model->image) {
            $model->image()->delete();
        }
    }
}
