<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    /**
     * @return Collection;
     */
    public function getAll()
    {
        return $this->model->all()->load('subCategories');
    }

    /**
     * @param Collection $cats
     * @param int $quantity
     * @return \Illuminate\Support\Collection
     */
    public function getRelatedProducts(Collection $cats, $quantity = 6)
    {
        $productsCollection = collect();

        foreach ($cats as $cat) {
            foreach ($cat->subCategories as $subCat) {
                $productsCollection->push(
                    $subCat->products()
                        ->random()
                        ->take($quantity)
                        ->get()
                );
            }
        }

        return $productsCollection;
    }
}
