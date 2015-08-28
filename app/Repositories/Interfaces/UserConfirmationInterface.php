<?php namespace Orbiagro\Repositories\Interfaces;

use Auth;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\Exceptions\DuplicateConfirmationException;

interface UserConfirmationInterface
{

    /**
     * @return Model
     */
    public function create();

    /**
     * @param string $data
     *
     * @return Model|null
     * @throws DuplicateConfirmationException
     */
    public function getConfirmation($data);

    /**
     * @param Model $model
     *
     * @return null|\Orbiagro\Models\User
     * @throws \Exception
     * @throws \LogicException
     */
    public function validateUser(Model $model);
}
