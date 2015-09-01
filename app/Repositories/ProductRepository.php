<?php namespace Orbiagro\Repositories;

use LogicException;
use Orbiagro\Models\Product;
use Orbiagro\Models\Direction;
use Orbiagro\Models\MapDetail;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
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

        if (is_null($user)) {
            return false;
        }

        return $user->isDisabled();
    }

    /**
     * @param array $data
     * @return Product
     */
    public function store(array $data)
    {
        /** @var Product $product */
        $product = $this->getEmptyInstance();

        $product->fill($data);

        $dir = $this->getDirectionModel($data);
        $map = $this->getMapModel($data);

        $results = $this->storeModels($product, $dir, $map);

        return $results;
    }

    /**
     * @param $id
     * @param array $data
     * @return Product
     */
    public function update($id, array $data)
    {
        /** @var Product $product */
        $product = $this->getById($id);

        $product->update($data);

        $this->updateRelatedModels($data, $product);

        return $product;
    }

    /**
     * @param string $parent
     * @param int $id
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
                throw new LogicException('No se puede determinar el repositorio adecuado para buscar los productos asociados.');
        }

        return $repo;
    }

    /**
     * @param array $data
     * @return Direction
     */
    protected function getDirectionModel(array $data)
    {
        $dir = new Direction($data);

        return $dir;
    }

    /**
     * @param array $data
     * @return MapDetail
     */
    protected function getMapModel(array $data)
    {
        $map = new MapDetail($data);

        return $map;
    }

    /**
     * @param Product $product
     * @param $dir
     * @param $map
     * @return mixed
     */
    protected function storeModels(Product $product, $dir, $map)
    {
        $user = $this->getCurrentUser();

        // se guardan los modelos
        $user->products()->save($product);
        $product->direction()->save($dir);
        $product->direction()->first()->map()->save($map);

        return $product;
    }

    /**
     * @param array $data
     * @param Product $product
     */
    protected function updateRelatedModels(array $data, Product $product)
    {
        $direction = $product->direction;

        $direction->parish_id = $data['parish_id'];
        $direction->details   = $data['details'];

        $direction->save();

        $map = $direction->map;

        if (!$map) {
            $map               = new MapDetail;
            $map->direction_id = $direction->id;
        }

        $map->latitude  = $data['latitude'];
        $map->longitude = $data['longitude'];
        $map->zoom      = $data['zoom'];
        $map->save();
    }
}
