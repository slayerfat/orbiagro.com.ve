<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Category;
use Orbiagro\Models\Product;
use Orbiagro\Models\SubCategory;
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
     * @return array
     */
    public function getIndexData()
    {
        $data = [
            'products' => Product::paginate(20),
            'cats'     => Category::all(),
            'subCats'  => SubCategory::all(),
        ];

        return $data;
    }
}
