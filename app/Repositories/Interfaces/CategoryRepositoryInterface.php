<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Category;

interface CategoryRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param Collection $cats
     * @param int $quantity
     *
     * @return Collection
     */
    public function getRelatedProducts(Collection $cats, $quantity = 6);

    /**
     * @param array $data
     *
     * @return Category
     */
    public function create(array $data);

    /**
     * @param Model $model
     *
     * @return Collection
     */
    public function getSubCats(Model $model);

    /**
     * @param       $id
     * @param array $data
     *
     * @return Category
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return bool|Model
     */
    public function delete($id);

    /**
     * @param  mixed $id
     *
     * @return Category
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Category
     */
    public function getById($id);

    /**
     * @return Category
     */
    public function getEmptyInstance();

    /**
     * Gets an associative array with
     * categories and subcategories.
     *
     * @return array
     */
    public function getArraySortedWithSubCategories();

    /**
     * @return array
     */
    public function getLists();
}
