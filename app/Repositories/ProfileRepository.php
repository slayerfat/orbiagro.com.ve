<?php namespace Orbiagro\Repositories;

use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{

    /**
     * @param string $desc
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getByDescription($desc)
    {
        return $this->model->whereDescription($desc)->first();
    }
}
