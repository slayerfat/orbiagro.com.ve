<?php namespace Orbiagro\Mamarrachismo\Upload;

use Exception;
use Validator;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Upload\Upload;
use Orbiagro\Models\File as FileModel;

class File extends Upload
{

    /**
     * Crea el archivo relacionado con algun modelo.
     *
     * @param Model        $model El modelo relacionado para ser asociado.
     * @param UploadedFile $file  Objeto UploadedFiles con la imagen.
     *
     * @return boolean
     */
    public function create(Model $model, UploadedFile $file = null)
    {
        $collection = collect();

        if ($file === null) {
            return $collection;
        }

        // el validador
        $validator = Validator::make(['file' => $file], $this->fileRules);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->all();
            throw new Exception("Error, archivo no valido", 3);
        }

        $this->path = $this->generatePathFromModel($model);

        // se crea el archivo en el HD.
        if (!$result = $this->makeFile($file, $this->path)) {
            return $collection;
        }

        // se crea el modelo.
        $collection->push($this->createFileModel($result, $model));

        return $collection;
    }

    /**
     * Actualiza el archivo relacionado con algun modelo.
     *
     * @param  Model        $model   Eloquen Model del padre asociado.
     * @param  UploadedFile $file    El modelo del archivo.
     * @param  array        $options Las opcions relacionadas, no implementado.
     *
     * @internal $options no implementadas.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(Model $model, UploadedFile $file = null, array $options = null)
    {
        if ($model->file == null) {
            // create devuelve una coleccion
            $result = $this->create($model, $file);

            return $result->first();
        }

        $fileModel = $model->file;

        $this->path = $this->generatePathFromModel($model);

        // el validador
        $validator = Validator::make(['file' => $file], $this->fileRules);

        if (!$file || $validator->fails()) {
            $this->errors = $validator;
            throw new Exception("Error, archivo no valido", 3);
        }

        // se chequea si existe el archivo y se elimina
        if (Storage::disk('public')->exists($fileModel->path)) {
            Storage::disk('public')->delete($fileModel->path);
        }

        // se crea la imagen en el HD y se actualiza el modelo.
        if ($result = $this->makeFile($file, $this->path, $options = null)) {
            return $fileModel->update($result);
        }

        return $fileModel;
    }

    // --------------------------------------------------------------------------
    // Funciones Privadas
    // --------------------------------------------------------------------------

    /**
     * crea el modelo nuevo de alguna imagen relacionada con algun producto.
     *
     * @param array  $array el array que contiene los datos para la imagen.
     * @param Model  $model el modelo a asociar.
     *
     * @return boolean
     */
    private function createFileModel(array $array, $model)
    {
        $file = new FileModel($array);

        switch (get_class($model)) {
            case 'Orbiagro\Models\Product':
                return $model->files()->save($file);

            case 'Orbiagro\Models\Feature':
                return $model->file()->save($file);

            default:
                throw new Exception('Modelo desconocido, no se puede guardar archivo.');
        }
    }
}
