<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\Product;
use Orbiagro\Models\SubCategory;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

class SubCategoryRepository extends AbstractRepository implements SubCategoryRepositoryInterface
{

    /**
     * @var CategoryRepositoryInterface
     */
    protected $catRepo;

    /**
     * @param SubCategory $model
     * @param CategoryRepositoryInterface $catRepo
     */
    public function __construct(SubCategory $model, CategoryRepositoryInterface $catRepo)
    {
        $this->catRepo = $catRepo;

        parent::__construct($model);
    }

    /**
     * @return SubCategory
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }

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

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->lists('description', 'id');
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getIndexByParent($id)
    {
        $cat = $this->catRepo->getBySlugOrId($id);

        return $cat->subCategories;
    }

    /**
     * @param SubCategory $subCat
     * @return Collection
     */
    public function getSibblings(SubCategory $subCat)
    {
        $subCats = $this->model
            ->where('category_id', $subCat->category_id)
            ->get();

        return $subCats;
    }

    /**
     * @param $subCatId
     * @param int $amount
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProductsPaginated($subCatId, $amount = 20)
    {
        $products = Product::where('sub_category_id', $subCatId)
            ->paginate($amount);

        return $products;
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->executeDelete($id, 'Rubro', 'Productos');
    }
}
