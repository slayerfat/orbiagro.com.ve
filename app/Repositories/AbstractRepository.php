<?php namespace Orbiagro\Repositories;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @param  mixed $id
     *
     * @return Model
     */
    public function getBySlugOrId($id)
    {
        $this->checkId($id);

        $model = $this->model
            ->where('slug', $id)
            ->orWhere('id', $id)
            ->firstOrFail();

        return $model;
    }

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getById($id)
    {
        $this->checkId($id);

        return $this->model->findOrFail($id);
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
     * @return null|\Orbiagro\Models\User
     */
    protected function getCurrentUser()
    {
        $user = Auth::user();

        return $user;
    }

    /**
     * @param $id
     *
     * @return void
     * @throws HttpException
     */
    protected function checkId($id)
    {
        if (is_null($id) || trim($id) == '') {
            throw new HttpException(
                '400',
                'Es necesario un identificador para continuar con el proceso.'
            );
        }
    }

    /**
     * @param $id
     *
     * @return bool
     */
    protected function canUserManipulate($id)
    {
        $user = $this->getCurrentUser();

        if ($user->isOwnerOrAdmin($id)) {
            return true;
        }

        return false;
    }
}
