<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Provider;
use Orbiagro\Repositories\Interfaces\ProductProviderRepositoryInterface;

class ProductProviderRepository extends AbstractRepository implements ProductProviderRepositoryInterface
{

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->lists('name', 'id');
    }

    /**
     * @return Provider
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }
}
