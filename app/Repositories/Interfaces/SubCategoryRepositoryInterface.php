<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\SubCategory;

interface SubCategoryRepositoryInterface
{
    /**
     * @param  mixed $id
     *
     * @return SubCategory
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return SubCategory
     */
    public function getById($id);

    /**
     * @return SubCategory
     */
    public function getRandom();

    /**
     * @return Collection
     */
    public function getAll();
}
