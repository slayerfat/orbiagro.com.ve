<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\Person;
use Orbiagro\Models\Product;
use Orbiagro\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param  mixed $id
     *
     * @return User
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return User
     */
    public function getByNameOrId($id);

    /**
     * @param  mixed $id
     *
     * @return User
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
    public function validateCreatePersonRequest($id);

    /**
     * @return Person
     */
    public function getEmptyPersonInstance();

    /**
     * @param $id
     * @param array $data
     * @return User
     */
    public function storePerson($id, array $data);

    /**
     * @param $id
     * @param array $data
     * @return User
     */
    public function updatePerson($id, array $data);

    /**
     * @return Collection
     */
    public function getAllWithTrashed();

    /**
     * @param $id
     * @return User
     */
    public function getWithProductVisits($id);

    /**
     * @param int $id
     * @return User
     */
    public function getWithChildrens($id);

    /**
     * @param $userId
     * @param int $paginatorAmount
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts($userId, $paginatorAmount = 4);

    /**
     * @param $id
     * @return User
     */
    public function getSingleWithTrashed($id);

    /**
     * @param $id
     * @return bool|User
     */
    public function delete($id);

    /**
     * @param $id
     * @return User
     */
    public function restore($id);

    /**
     * @param $id
     * @return bool|User
     */
    public function forceDelete($id);
}
