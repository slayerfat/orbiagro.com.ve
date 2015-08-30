<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Category;
use Orbiagro\Models\Product;
use Orbiagro\Models\SubCategory;

interface ProductRepositoryInterface
{

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

    /**
     * @return array
     */
    public function getIndexData();
}
