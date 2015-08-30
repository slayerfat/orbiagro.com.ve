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
        return new Person;
    }

    /**
     * @param int $id
     * @return User|bool
     */
    public function validateCreatePersonRequest($id)
    {
        $user = $this->getCurrentUser();

        if (is_null($user)) {
            return false;
        }

        if ($this->canUserManipulate($user->id)) {
            return $this->getByNameOrId($id);
        }

        return false;
    }

    /**
     * @param $id
     * @param array $data
     * @return User
     */
    public function storePerson($id, array $data)
    {
        $user = $this->getById($id);

        $person = $this->getEmptyPersonInstance();

        $person->fill($data);

        $person->gender_id = $data['gender_id'];
        $person->nationality_id = $data['nationality_id'];

        $user->person()->save($person);

        return $user;
    }

    /**
     * @param $id
     * @param array $data
     * @return User
     */
    public function updatePerson($id, array $data)
    {
        $user = $this->getById($id);

        $user->person->fill($data);

        $user->person->gender_id = $data['gender_id'];
        $user->person->nationality_id = $data['nationality_id'];

        $user->person->update();

        return $user;
    }
}
