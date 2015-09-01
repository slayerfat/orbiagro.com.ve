<?php namespace Orbiagro\Repositories\Interfaces;

use Exception;
use LogicException;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Repositories\Exceptions\DuplicateConfirmationException;

interface UserConfirmationInterface
{

    /**
     * @return Model
     *
     * @throws LogicException
     */
    public function create();

    /**
     * @param $data
     *
     * @return Model|null
     * @throws DuplicateConfirmationException
     */
    public function getConfirmation($data);

    /**
     * @param Model $model
     *
     * @return null|\Orbiagro\Models\User
     * @throws Exception
     * @throws LogicException
     */
    public function validateUser(Model $model);
}
