<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Feature;
use Orbiagro\Models\Product;

interface FeatureRepositoryInterface
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
     * @param $productId
     *
     * @return bool
     */
    public function validateCreateRequest($productId);

    /**
     * @param array   $data
     * @param Product $product
     *
     * @return Feature
     */
    public function create(array $data, Product $product);

    /**
     * @param $id
     * @param array $data
     *
     * @return Feature
     */
    public function update($id, array $data);

    /**
     * @param $id
     *
     * @return Feature|bool
     */
    public function delete($id);
}
