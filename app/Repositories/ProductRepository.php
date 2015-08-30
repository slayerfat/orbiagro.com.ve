<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Product;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    /**
     * @var CategoryRepositoryInterface
     */
    protected $catRepo;

    /**
     * @var SubCategoryRepositoryInterface
     */
    protected $subCatRepo;

    /**
     * @param Product $product
     * @param CategoryRepositoryInterface $catRepo
     * @param SubCategoryRepositoryInterface $subCatRepo
     */
    public function __construct(
        Product $product,
        CategoryRepositoryInterface $catRepo,
        SubCategoryRepositoryInterface $subCatRepo
    ) {

        $this->catRepo = $catRepo;
        $this->subCatRepo = $subCatRepo;

        parent::__construct($product);
    }

    /**
     * @return Product
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }


    /**
     * @param int $perPage el numero por pagina
     * @return mixed
     */
    public function getPaginated($perPage)
    {
        return Product::paginate($perPage);
    }

    /**
     * @return bool
     */
    public function isCurrentUserDisabled()
    {
        $user = $this->getCurrentUser();

        return $user->isDisabled();
    }
}
