<?php namespace Orbiagro\Repositories;

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
}
