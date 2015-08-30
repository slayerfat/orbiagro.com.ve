<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Person;
use Orbiagro\Models\User;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @param $id
     *
     * @return bool
     */
    public function canUserManipulate($id)
    {
        $user = $this->getCurrentUser();

        return $user->isOwnerOrAdmin($id);
    }

    /**
     * @return User
     */
    public function getEmptyUserInstance()
    {
        return $this->getNewInstance();
    }

    /**
     * @return Person
     */
    public function getEmptyPersonInstance()
    {
        return $this->getNewInstance();
    }

    /**
     * @param int $id
     * @return User|bool
     */
    public function createPersonModel($id)
    {
        $user = $this->getCurrentUser();

        if (is_null($user)) {
            return false;
        }

        return $this->getByNameOrId($id);
    }
}
