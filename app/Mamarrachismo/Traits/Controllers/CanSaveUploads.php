<?php namespace Orbiagro\Mamarrachismo\Traits\Controllers;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Orbiagro\Http\Requests\Request;
// el abstracto de ImageUpload y FileUpload
use Orbiagro\Mamarrachismo\Upload\Upload;
use Orbiagro\Mamarrachismo\Upload\Image as ImageUpload;
use Orbiagro\Mamarrachismo\Upload\File as FileUpload;

trait CanSaveUploads
{

    /**
     * Crea una imagen de algun modelo relacionado.
     *
     * @param  Request $request
     * @param  Model   $model
     *
     * @return void
     */
    protected function createImage(Request $request, Model $model)
    {
        $uploader = new ImageUpload($request->user()->id);

        $this->createPrototype($model, $uploader, $request->file('image'));
    }

    /**
     * Crea varias imagenes de algun modelo relacionado.
     *
     * @param  Request $request
     * @param  Model   $model
     *
     * @return void
     */
    protected function createImages(Request $request, Model $model)
    {
        $uploader = new ImageUpload($request->user()->id);

        $uploader->createImages($model, $request->file('images'));
    }

    /**
     * Crea un archivo de algun modelo relacionado.
     *
     * @param  Request $request
     * @param  Model   $model
     *
     * @return void
     */
    protected function createFile(Request $request, Model $model)
    {
        $uploader = new FileUpload($request->user()->id);

        $this->createPrototype($model, $uploader, $request->file('file'));
    }

    /**
     * El prototipo interno para crear las imagenes y archivos.
     *
     * @param  Model        $model    Eloquent Model asociado
     *                                (el padre: padre[product]->hijo[image])
     * @param  Upload       $uploader
     * @param  UploadedFile $file
     *
     * @return void
     */
    private function createPrototype(Model $model, Upload $uploader, UploadedFile $file = null)
    {
        try {
            $uploader->create($model, $file);
        } catch (\Exception $e) {
            flash()->warning('Algunos Archivos no fueron guardados.');
        }
    }

    /**
     * Actualiza una imagen de algun modelo relacionado.
     *
     * @param  Request $request
     * @param  Model   $model
     * @return void
     */
    protected function updateImage(Request $request, Model $model)
    {
        $uploader = new ImageUpload($request->user()->id);

        $this->updatePrototype($model, $uploader, $request->file('image'));
    }

    /**
     * Actualiza un archivo de algun modelo relacionado.
     *
     * @param  Request $request
     * @param  Model   $model
     * @return void
     */
    protected function updateFile(Request $request, Model $model)
    {
        $uploader = new FileUpload($request->user()->id);

        $this->updatePrototype($model, $uploader, $request->file('file'));
    }

    /**
     * Prototipo interno para actualizar imagenes y archivos.
     *
     * @param  Model        $model
     * @param  Upload       $uploader
     * @param  UploadedFile $file
     *
     * @return void
     */
    private function updatePrototype(Model $model, Upload $uploader, UploadedFile $file = null)
    {
        if ($file) {
            try {
                $uploader->update($model, $file);
            } catch (\Exception $e) {
                flash()->warning('Algunos Archivos no fueron actualizados.');
            }
        }
    }
}
