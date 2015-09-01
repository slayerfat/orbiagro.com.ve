<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\Person;
use Orbiagro\Models\Product;
use Orbiagro\Models\User;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllWithTrashed()
    {
        return $this->model->with('person')->withTrashed()->get();
    }

    /**
     * @param $id
     * @return User
     */
    public function getSingleWithTrashed($id)
    {
        $user = $this->model
            ->with('person', 'products', 'profile')
            ->where('name', $id)
            ->orWhere('id', $id)
            ->withTrashed()
            ->firstOrFail();

        return $user;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getWithChildrens($id)
    {
        $user = $this->model->with('person', 'products', 'profile')
            ->where('name', $id)
            ->orWhere('id', $id)
            ->firstOrFail();

        return $user;
    }

    /**
     * @param $id
     * @return User
     */
    public function getWithProductVisits($id)
    {
        $user = $this->model->with(['visits' => function ($query) {
            $query->where('visitable_type', Product::class)
                  ->orderBy('updated_at', 'desc');
        }])->where('name', $id)->orWhere('id', $id)->firstOrFail();

        return $user;
    }

    /**
     * @param $userId
     * @param int $paginatorAmount
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts($userId, $paginatorAmount = 4)
    {
        return Product::where('user_id', $userId)->paginate($paginatorAmount);
    }

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

    /**
     * @param $id
     * @return bool|User
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Usuario');
    }

    /**
     * @param $id
     * @return bool|User
     */
    public function forceDelete($id)
    {
        return $this->executeForceDestroy($id, 'Usuario');
    }

    /**
     * @param $id
     * @return User
     */
    public function restore($id)
    {
        $this->checkId($id);

        $user = $this->findTrashedUser($id);

        $user->restore();

        return $user;
    }

    /**
     * @param $id
     * @return User
     */
    protected function findTrashedUser($id)
    {
        /** @var User $user */
        $user = $this->model->where('id', $id)
            ->withTrashed()
            ->firstOrFail();

        return $user;
    }
}
