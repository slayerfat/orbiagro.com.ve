<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Category;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAll()
    {
        return $this->model->has('subCategories')->with('subCategories')->get();
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->pluck('description', 'id');
    }

    /**
     * @return Category
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }

    /**
     * @param Collection $cats
     * @param int $quantity
     *
     * @return Collection
     */
    public function getRelatedProducts(Collection $cats, $quantity = 6)
    {
        $collection = collect();

        $cats->each(function (Category $cat) use ($quantity, $collection) {
            foreach ($cat->subCategories as $subCat) {
                if (!$subCat->products->isEmpty()) {
                    $collection->push(
                        $subCat->products()
                            ->random()
                            ->take($quantity)
                            ->get()
                    );
                }
            }
        });

        return $collection;
    }


    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data = [])
    {
        $cat = $this->getNewInstance($data);

        $cat->save($data);

        return $cat;
    }

    /**
     * @param Model|Category $model
     *
     * @return Collection
     */
    public function getSubCats(Model $model)
    {
        return $model->subCategories;
    }

    /**
     * @param       $id
     * @param array $data
     *
     * @return Model
     */
    public function update($id, array $data)
    {
        $cat = $this->model->findOrFail($id)
            ->load('image');

        $cat->update($data);

        return $cat;
    }

    /**
     * @param $id
     * @return bool|Model
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Categoria');
    }

    /**
     * @return array
     */
    public function getArraySortedWithSubCategories()
    {
        $catModels = $this->getAll();

        return $this->toAsocArray($catModels);
    }

    /**
     * devuelve un array asociativo con los elementos
     * y sus subelementos.
     *
     * @todo abstraer a un metodo generico.
     *
     * @param Collection $models
     *
     * @return array
     */
    private function toAsocArray(Collection $models)
    {
        $cats = [];

        if (!$models) {
            return null;
        }

        foreach ($models as $cat) {
            foreach ($cat->subCategories as $subCat) {
                $cats[$cat->description][$subCat->id] = $subCat->description;
            }
        }

        return $cats;
    }
}
