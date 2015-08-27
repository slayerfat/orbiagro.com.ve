<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{

    /**
     * El modelo a ser manipulado
     *
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Devuelve una nueva instancia del modelo (Products, User, etc).
     *
     * @param  array $data
     *
     * @return Model
     */
    public function getNewInstance(array $data = [])
    {
        return $this->model->newInstance($data);
    }

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getBySlugOrId($id)
    {
        $model = $this->model
            ->where('slug', $id)
            ->first();

        if (!$model) {
            $model = $this->model->findOrFail($id);
        }

        return $model;
    }

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
}
