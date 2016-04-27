<?php namespace Orbiagro\Mamarrachismo\Upload;

use File;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use Orbiagro\Models\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Upload
{

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
     *
     * @var string
     */
    protected $path;

    /**
     * reglas para el validador.
     *
     * @var array
     */
    protected $imageRules = ['image' => 'required|mimes:jpeg,bmp,png,jpg,pjpeg,gif|between:1,4096'];

    /**
     * reglas para el validador.
     *
     * @var array
     */
    protected $fileRules = ['file' => 'mimes:pdf|between:1,10240'];

    /**
     * Para Utilizar esta clase es casi siempre necesario el uso del ID
     * de algun usuario (para asociarlo al created_by o updated_by).
     *
     * @param int $userID
     */
    public function __construct($userID = null)
    {
        if ($userID !== null) {
            $this->userId = $userID;
        }
    }

    /**
     * @param Model $model El modelo relacionado para ser asociado.
     * @param UploadedFile $file Objeto UploadedFiles con la imagen.
     *
     * @return \Illuminate\Support\Collection
     */
    abstract public function create(Model $model, UploadedFile $file = null);

    /**
     * @param Model $model El modelo Eloquent.
     * @param UploadedFile $file Objeto UploadedFiles con el archivo.
     * @param array $options Las opcions relacionadas la operacion.
     *
     * @return Model
     */
    abstract public function update(Model $model, UploadedFile $file = null, array $options = null);

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
        // generamos el nombre del archivo
        $name   = date('Ymdhms-') . str_random(16);
        $ext    = $file->getClientOriginalExtension();
        $target = "{$path}/{$name}.{$ext}";

        // si el directorio no existe, entonces lo
        // creamos y le asignamos el grupo correcto.
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0775, true);
            chgrp(public_path($path), env('APP_GROUP'));
        }

        // movemos el archivo a la carpeta publica.
        File::move($file->getRealPath(), public_path($target));
        chgrp(public_path($target), env('APP_GROUP'));

        // la data necesaria para crear el modelo de imagen.
        $data = [
            'name'   => $name,
            'ext'    => $ext,
            'dir'    => $path,
            'path'   => $target,
            'public' => public_path($target),
            'mime'   => $file->getClientMimeType(),
        ];

        return $data;
    }

    /**
     * Determina cuales son los datos correctos para
     * crear un directorio adecuado en el sistema.
     *
     * @param $model
     * @return string
     * @throws LogicException
     */
    protected function generatePathFromModel($model)
    {
        $dir = strtolower(class_basename($model));

        switch (get_class($model)) {
            case 'Orbiagro\Models\Product':
                return "{$dir}/{$model->id}";

            case 'Orbiagro\Models\Feature':
                $productDir = class_basename(Product::class);

                $productDir = strtolower($productDir);

                return "{$productDir}/{$model->product->id}/{$dir}";

            case 'Orbiagro\Models\Category':
                return "{$dir}/{$model->id}";

            case 'Orbiagro\Models\SubCategory':
                return "{$dir}/{$model->id}";

            case 'Orbiagro\Models\Maker':
                return "{$dir}/{$model->id}";

            case 'Orbiagro\Models\Promotion':
                return "{$dir}/{$model->id}";

            default:
                throw new LogicException('Modelo desconocido, no se puede crear ruta, modelo ' . get_class($model));
        }
    }
}
