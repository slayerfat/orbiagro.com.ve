<?php namespace Orbiagro\Repositories\Interfaces\Common;

interface CommonRepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data);


    /**
     * @param $id
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function delete($id);

    /**
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id);

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEmptyInstance();

    /**
     * @return array
     */
    public function getLists();
}
