<?php namespace App\Mamarrachismo\Traits\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Request;
use App\Mamarrachismo\Upload\Image as ImageUpload;
use App\Mamarrachismo\Upload\File as FileUpload;
use App\Mamarrachismo\Upload\Upload;

trait CanSaveUploads
{
    protected function createImage(Request $request, Model $model)
    {
        $uploader = new ImageUpload($request->user()->id);

        return $uploader->create($model, $request->file('image'));
    }

    protected function updateImage(Request $request, Model $model)
    {
        $uploader = new ImageUpload($request->user()->id);

        $this->updatePrototype($request, $model, $uploader);
    }

    protected function updateFile(Request $request, Model $model)
    {
        $uploader = new FileUpload($request->user()->id);

        $this->updatePrototype($request, $model, $uploader);
    }

    private function updatePrototype(Request $request, Model $model, Upload $uploader)
    {
        if ($request->hasFile('image')) {
            try {
                $uploader->update($model, $request->file('image'));
            } catch (\Exception $e) {
                flash()->warning('La imagen asociada no pudo ser actualizada.');
            }
        }
    }
}
