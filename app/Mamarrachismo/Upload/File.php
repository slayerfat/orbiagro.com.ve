<?php namespace App\Mamarrachismo\Upload;

use Exception;
use Validator;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Mamarrachismo\Upload\Upload;
use App\File as Model;

class File extends Upload
{

    /**
    * crea la imagen relacionada con algun modelo.
    *
    * @param object        $model El modelo relacionado para ser asociado.
    * @param UploadedFile  $file  Objeto UploadedFiles con la imagen.
    *
    * @return boolean
    */
    public function createFile($model, UploadedFile $file = null)
    {
        $this->path = $this->generatePathFromModel($model);

        // el validador
        $validator = Validator::make(['file' => $file], $this->fileRules);
        if (!$file || $validator->fails()) {
            $this->errors = $validator->errors()->all();
            throw new Exception("Error, archivo no valido", 3);
        }

        // se crea el archivo en el HD.
        if (!$result = $this->makeFile($file, $this->path)) {
            return false;
        }

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
    public function updateFile(UploadedFile $file = null, $parentModel = null, Model $fileModel = null)
    {
        if ($fileModel == null) {
            return $this->createFile($file, $parentModel);
        }

        $this->path = $this->generatePathFromModel($parentModel);

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
        if ($result = $this->makeFile($file, $this->path)) {
            return $fileModel->update($result);
        }
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
    private function createFileModel(array $array, $model)
    {
        $file = new Model($array);

        switch (get_class($model)) {
            case 'App\Product':
                return $model->files()->save($file);

            case 'App\Feature':
                return $model->file()->save($file);

            default:
                throw new Exception("Error: modelo desconocido, no se puede guardar archivo relacionado", 1);
        }
    }
}
