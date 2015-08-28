<?php namespace Orbiagro\Repositories;

use Auth;
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
    protected function getNewInstance(array $data = [])
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
            return $this->getById($id);
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

    /**
     * @return null|\Orbiagro\Models\User
     */
    protected function getCurrentUser()
    {
        $user = Auth::user();

        return $user;
    }
}
