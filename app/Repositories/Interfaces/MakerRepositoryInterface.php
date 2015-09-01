<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\Maker;

interface MakerRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param array $data
     *
     * @return Maker
     */
    public function create(array $data);

    /**
     * @param       $id
     * @param array $data
     *
     * @return Maker
     */
    public function update($id, array $data);


    public function delete($id);

    /**
     * @param  mixed $id
     *
     * @return Maker
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Maker
     */
    public function getById($id);

    /**
     * @return Maker
     */
    public function getEmptyInstance();

    /**
     * @return array
     */
    public function getLists();
}
