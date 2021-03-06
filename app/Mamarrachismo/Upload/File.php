<?php namespace Orbiagro\Mamarrachismo\Upload;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Upload\Exceptions\FileValidationFail;
use Orbiagro\Models\File as FileModel;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Validator;

class File extends Upload
{

    /**
     * Crea el archivo relacionado con algun modelo.
     *
     * @param Model $model El modelo relacionado para ser asociado.
     * @param UploadedFile $file Objeto UploadedFiles con la imagen.
     * @return bool
     * @throws FileValidationFail
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
            throw new FileValidationFail('Archivo no valido.', $this->errors);
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
     * @param  Model $model Eloquen Model del padre asociado.
     * @param  UploadedFile $file El modelo del archivo.
     * @param  array $options Las opcions relacionadas, no implementado.
     * @return Model
     * @throws FileValidationFail
     * @internal $options no implementadas.
     *
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
            $this->errors = $validator->errors()->all();
            throw new FileValidationFail('Archivo no valido.', $this->errors);
        }

        // se chequea si existe el archivo y se elimina
        if (Storage::disk('public')->exists($fileModel->path)) {
            Storage::disk('public')->delete($fileModel->path);
        }

        // se crea la imagen en el HD y se actualiza el modelo.
        $result = $this->makeFile($file, $this->path, $options = null);

        if ($result) {
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
     * @param array $array el array que contiene los datos para la imagen.
     * @param Model $model el modelo a asociar.
     * @return bool
     * @throws Exception
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
