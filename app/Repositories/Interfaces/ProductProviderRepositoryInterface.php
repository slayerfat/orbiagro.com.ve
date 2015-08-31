<?php namespace Orbiagro\Repositories\Interfaces;

use Orbiagro\Models\Provider;

interface ProductProviderRepositoryInterface
{

    /**
     * @return array
     */
    public function getLists();

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * @param  mixed $id
     *
     * @return Provider
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Provider
     */
    public function getById($id);

    /**
     * @return Provider
     */
    public function getEmptyInstance();

    /**
     * @param array $data
     * @return provider
     */
    public function store(array $data);

    /**
     * @param $id
     * @param array $data
     * @return provider
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id);
}
