<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Direction;
use Orbiagro\Models\MapDetail;
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
     * @param $id
     *
     * @return bool
     */
    public function canUserManipulate($id)
    {
        return parent::canUserManipulate($id);
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
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginated($perPage)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * @param $id
     * @return Product
     */
    public function getByIdWithTrashed($id)
    {
        $product = $this->model->withTrashed()->findOrFail($id);

        return $product;
    }

    /**
     * @return bool
     */
    public function isCurrentUserDisabled()
    {
        $user = $this->getCurrentUser();

        return $user->isDisabled();
    }

    /**
     * @param array $data
     * @return Product
     */
    public function store(array $data)
    {
        /** @var Product $product */
        $product    = $this->model->newInstance($data);
        $dir        = new Direction($data);
        $map        = new MapDetail($data);

        $user = $this->getCurrentUser();

        // se guardan los modelos
        $user->products()->save($product);
        $product->direction()->save($dir);
        $product->direction->map()->save($map);

        return $product;
    }

    /**
     * @param $id
     * @param array $data
     * @return Product
     */
    public function update($id, array $data)
    {
        $product = $this->getById($id);

        $product->update($data);

        $direction = $product->direction;

        $direction->parish_id = $data['parish_id'];
        $direction->details = $data['details'];

        $direction->save();

        $map = $direction->map;

        if (!$map) {
            $map = new MapDetail;
            $map->direction_id = $direction->id;
        }

        $map->latitude = $data['latitude'];
        $map->longitude = $data['longitude'];
        $map->zoom = $data['zoom'];
        $map->save();

        return $product;
    }

    /**
     * @param $parent
     * @param $id
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getByParentSlugOrId($parent, $id)
    {
        $repo = $this->getParentRepo($parent);

        $repo = $repo->getBySlugOrId($id);

        $products = $repo->products()->paginate(20);

        return $products;
    }

    /**
     * @param $parent
     * @return CategoryRepositoryInterface|SubCategoryRepositoryInterface
     */
    protected function getParentRepo($parent)
    {
        switch ($parent) {
            case 'category':
                $repo = $this->catRepo;
                break;

            case 'subCategory':
                $repo = $this->subCatRepo;
                break;

            default:
                throw new \LogicException('No se puede determinar el repositorio adecuado para buscar los productos asociados.');
        }

        return $repo;
    }
}
