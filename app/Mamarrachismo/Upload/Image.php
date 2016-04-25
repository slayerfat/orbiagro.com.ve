<?php namespace Orbiagro\Mamarrachismo\Upload;

use Exception;
use File;
use Illuminate\Database\Eloquent\Model;
use Intervention;
use Log;
use LogicException;
use Orbiagro\Mamarrachismo\Upload\Exceptions\ImageValidationFail;
use Orbiagro\Mamarrachismo\Upload\Exceptions\OrphanImageException;
use Orbiagro\Models\Image as ImageModel;
use Orbiagro\Repositories\Exceptions\DefaultImageFileNotFoundException;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Validator;

class Image extends Upload
{

    /**
     * crea la imagen relacionada con algun modelo.
     *
     * @param Model $model El modelo relacionado para ser asociado.
     * @param UploadedFile $file Objeto UploadedFiles con la imagen.
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
     * crea la(s) imagen(es) relacionadas con algun modelo.
     *
     * @param Model $model El modelo a relacionar con la imagen.
     * @param array $array El array con los objetos UploadedFiles.
     * @return \Illuminate\Support\Collection
     * @throws LogicException
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

                    $this->errors = $validator->errors()->all();
                    Log::debug($this->errors);

                    return $collection;
                }

                $this->errors = $validator->errors()->all();

                throw new LogicException('Imagenes no validas.');
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
     * Crea la imagen por defecto relacionada con algun modelo.
     *
     * @param Model $model
     * @param null $modelPath
     * @return Model
     * @throws DefaultImageFileNotFoundException
     * @throws Exception
     */
    public function createDefaultImage(Model $model, $modelPath = null)
    {
        $modelPath = $this->getModelPath($model, $modelPath);

        $this->checkModelImage($model);

        // el nombre del archivo
        $name = date('Ymdhmmss-') . str_random(20);
        $path = "{$modelPath}/{$name}.gif";

        // si no existe el directorio lo creamos
        // y le asignamos el grupo correcto.
        if (!File::exists(public_path($modelPath))) {
            File::makeDirectory(public_path($modelPath), 0775, true);
            chgrp(public_path($modelPath), env('APP_GROUP'));
        }

        // se copia el archivo
        if (!Storage::disk('public')->copy('sin_imagen.gif', $path)) {
            throw new DefaultImageFileNotFoundException('Imagen por defecto no puede ser creada.');
        }

        // una vez creado el archivo debemos cambiar el grupo.
        chgrp(public_path($path), env('APP_GROUP'));

        // la data necesaria para crear el modelo de imagen.
        $data = [
            'name'   => $name,
            'ext'    => 'gif',
            'dir'    => $modelPath,
            'path'   => $path,
            'public' => public_path($path),
            'mime'   => 'image/gif',
        ];

        $data = $this->makeOriginalFile($data);

        // para seeding y otros:
        unset($data['name'], $data['ext'], $data['dir']);

        return $this->createImageModel($data, $model);
    }

    /**
     * Obtiene la direccion para generar alguna imagen.
     *
     * @param Model $model
     * @param $modelPath
     * @return string
     */
    private function getModelPath(Model $model, $modelPath)
    {
        if ($modelPath === null) {
            if (isset($this->path)) {
                return $this->path;
            }

            return $this->path = $this->generatePathFromModel($model);
        }

        return $modelPath;
    }

    /**
     * Elimina la imagen en la base de datos.
     *
     * @param Model|\Orbiagro\Models\Product $model
     */
    private function checkModelImage(Model $model)
    {
        if ($model->image) {
            $model->image()->delete();
        }
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
        // para evitarnos problemas en el futuro, se separan las variables
        // en publicas y no publicas para poder extraer las mismas
        // desde las vistas por medio de asset()
        $data['original']        = $data['dir'] . '/o-' . $data['name'] . '.' . $data['ext'];
        $data['public_original'] = public_path($data['original']);

        // creamos una copia del objeto para poder manipularlo
        // y hacer diferentes tamaños por defecto.
        Intervention::make($data['public'])->save($data['public_original']);

        // creamos el objeto a manipular
        $image = Intervention::make($data['public_original']);
        // le asignamos el grupo correcto.
        chgrp($data['public_original'], env('APP_GROUP'));
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
            throw new LogicException('Directorio relacionado desconocido.', 6);
        }

        // datos de la imagen
        $dir          = $image->dirname;
        $filename     = $image->filename;
        $ext          = $image->extension;
        $originalPath = $dir . '/' . $image->basename;

        // datos para relacionar con el modelo
        $data = [
            'small'  => $data['dir'] . '/s-' . $filename . '.' . $ext,
            'medium' => $data['dir'] . '/m-' . $filename . '.' . $ext,
            'large'  => $data['dir'] . '/l-' . $filename . '.' . $ext,
        ];

        // para el foreach
        $sizes = [
            128  => $data['small'],
            512  => $data['medium'],
            1024 => $data['large'],
        ];

        foreach ($sizes as $size => $path) {
            // se crea una instancia cada vez que inicia el ciclo
            // para modificar la imagen original y no el resultado de la operacion
            $image = Intervention::make($originalPath);

            $image->fit($size)->save(public_path($path));
            chgrp(public_path($path), env('APP_GROUP'));
        }

        return $data;
    }

    /**
     * crea el modelo nuevo de alguna imagen relacionada con algun producto.
     *
     * @param array $array el array que contiene los datos para la imagen.
     * @param Model|\Orbiagro\Models\Product $model el modelo a asociar.
     * @return Model
     * @throws Exception
     */
    private function createImageModel(array $array, Model $model)
    {
        $image           = new ImageModel;
        $image->path     = $array['path'];
        $image->original = $array['original'];
        $image->small    = $array['small'];
        $image->medium   = $array['medium'];
        $image->large    = $array['large'];

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
                    . get_class($model)
                    . 'desconocido, no se puede guardar imagen.'
                );
        }
    }

    /**
     * usado para crear en el disco duro el archivo relacionado a un producto.
     *
     * @param  UploadedFile $file
     * @param  string $path la direccion a donde se guardara el archivo.
     * @param  array $options las opcions relacionadas con Intervention.
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
     * Actualiza la imagen relacionada con algun modelo.
     *
     * @param Model $model El modelo Eloquent.
     * @param UploadedFile $file Objeto UploadedFiles con el archivo.
     * @param array $options Las opcions relacionadas la operacion.
     * @return Model
     * @throws DefaultImageFileNotFoundException
     * @throws Exception
     * @throws OrphanImageException
     * @throws ImageValidationFail
     */
    public function update(Model $model, UploadedFile $file = null, array $options = null)
    {
        if (!$model instanceof ImageModel) {
            $this->checkModelImage($model);

            Log::alert(
                'Posible manipulacion de archivos en carpeta publica.',
                ['self' => $this, 'mode' => $model, 'user' => \Auth::user()]
            );

            flash()->warning('Problemas inesperados en el servidor.');

            return $this->createDefaultImage($model);
        }

        /** @var Model $parentModel */
        $parentModel = $model->imageable;

        if ($parentModel == null) {
            throw new OrphanImageException(
                'La imagen con id: ' . $model->id
                . ' no posee padre.',
                $model->id
            );
        }

        $this->path = $this->generatePathFromModel($parentModel);

        // el validador
        $validator = Validator::make(['image' => $file], $this->imageRules);

        if (!isset($file) || $validator->fails()) {
            $this->errors = $validator->errors()->all();

            throw new ImageValidationFail('Archivo no valido.', $this->errors);
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
     * elimina todas las imagenes del disco duro.
     *
     * @param ImageModel $imageModel El modelo de la imagen.
     * @param boolean $all para determinar si se elimina del disco duro TODOS los archivos.
     *
     * @return void
     */
    public function deleteImageFiles($imageModel, $all)
    {
        $paths = [
            $imageModel->small,
            $imageModel->medium,
            $imageModel->large,
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
                        'path'           => $path,
                        'user'           => \Auth::user(),
                    ]
                );

                continue;
            }

            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Cropea la imagen y la persiste en la BD.
     *
     * @param  Model|ImageModel $image la imagen.
     * @param  int $width
     * @param  int $height
     * @param  int $posX
     * @param  int $posY
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
}
