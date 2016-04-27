<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Feature;
use Orbiagro\Models\Product;
use Orbiagro\Repositories\Interfaces\FeatureRepositoryInterface;

class FeatureRepository extends AbstractRepository implements FeatureRepositoryInterface
{

    /**
     * @var Feature
     */
    protected $model;

    /**
     * @param $productId
     * @return bool
     */
    public function validateCreateRequest($productId)
    {
        $this->checkId($productId);

        $result = $this->model->whereProductId($productId)->count();

        if ($result < 5) {
            return $this->canUserManipulate($productId);
        }

        return false;
    }

    /**
     * @param array $data
     * @param Product $product
     * @return Feature
     */
    public function create(array $data, Product $product)
    {
        $feature = $this->getNewInstance($data);

        $product->features()->save($feature);

        return $feature;
    }

    /**
     * @param $id
     * @param array $data
     * @return Feature
     */
    public function update($id, array $data)
    {
        $feature = $this->getById($id);

        $feature->update($data);

        $feature->load('product', 'product.user');

        return $feature;
    }

    /**
     * @param $id
     * @return Feature|bool
     */
    public function delete($id)
    {
        /** @var Feature $feature */
        $feature = $this->getById($id);

        if (!$this->canUserManipulate($feature->product->user_id)) {
            return false;
        }

        $feature->load('product', 'product.user');

        $feature->delete();

        return $feature;
    }
}
