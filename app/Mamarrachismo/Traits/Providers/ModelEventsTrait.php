<?php namespace Orbiagro\Mamarrachismo\Traits\Providers;

use Orbiagro\Models\Image;
use Storage;

trait ModelEventsTrait
{

    /**
     * @var Image
     */
    private $image;

    /**
     * crea el hook segun el modelo para ser asociado con
     * algun id de usuario al momento de ser creado o actualizado.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  int $id
     * @return void
     */
    protected function creatingAndUpdatingEvents($model, $id)
    {
        $model::creating(function ($mdl) use ($id) {
            $mdl->created_by = $id;
            $mdl->updated_by = $id;
        });

        $model::updating(function ($mdl) use ($id) {
            $mdl->updated_by = $id;
        });
    }

    /**
     * crea el hook segun el modelo para ser asociado con
     * algun id de usuario al momento de ser creado o actualizado.
     *
     * @param  string $model
     * @return void
     */
    protected function deleteEventsWithImage($model)
    {
        $model::deleting(function ($mdl) {
            $this->image = $mdl->image;

            $this->id = $mdl->id;
        });

        $model::deleted(function () use ($model) {
            if ($this->image) {
                $this->image->delete();
            }

            $dir = strtolower(class_basename($model));

            Storage::disk('public')->deleteDirectory("{$dir}/{$this->id}");
        });
    }
}
