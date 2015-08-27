<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CategoryRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param Collection $cats
     * @param int        $quantity
     *
     * @return Collection
     */
    public function getRelatedProducts(Collection $cats, $quantity = 6);

    /**
     * @param array $data
     *
     * @return Model
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
     *@return Model
     */
    public function update($id, array $data);

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id);

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getById($id);
}
