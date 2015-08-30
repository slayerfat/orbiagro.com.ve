<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Person;
use Orbiagro\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getByNameOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getById($id);

    /**
     * @return User
     */
    public function getEmptyUserInstance();

    /**
     * @param $id
     *
     * @return bool
     */
    public function canUserManipulate($id);

    /**
     * @param int $id
     * @return User|bool
     */
    public function createPersonModel($id);

    /**
     * @return Person
     */
    public function getEmptyPersonInstance();
}
