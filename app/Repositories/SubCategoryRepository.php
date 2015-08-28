<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\SubCategory;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

class SubCategoryRepository extends AbstractRepository implements SubCategoryRepositoryInterface
{

    /**
     * @return SubCategory
     */
    public function getRandom()
    {
        return $this->model
            ->has('products')
            ->random()
            ->first();
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }
}
