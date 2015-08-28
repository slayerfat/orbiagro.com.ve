<?php namespace Orbiagro\Repositories;

use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{

    /**
     * @param $desc
     *
     * @return mixed|static
     */
    public function getByDescription($desc)
    {
        return $this->model->whereDescription($desc)->first();
    }
}
