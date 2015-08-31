<?php namespace Orbiagro\Repositories\Interfaces;

use Orbiagro\Models\Provider;

interface ProductProviderRepositoryInterface
{

    /**
     * @return array
     */
    public function getLists();

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
}
