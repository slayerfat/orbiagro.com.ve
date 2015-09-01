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

    /**
     * @param $id
     * @return Collection
     */
    public function getIndexByParent($id);

    /**
     * @return array
     */
    public function getLists();

    /**
     * @return SubCategory
     */
    public function getEmptyInstance();

    /**
     * @param SubCategory $subCat
     * @return Collection
     */
    public function getSibblings(SubCategory $subCat);

    /**
     * @param $subCatId
     * @param int $amount
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProductsPaginated($subCatId, $amount = 20);

    /**
     * @param int $id
     */
    public function delete($id);
}
