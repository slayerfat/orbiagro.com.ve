<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll();

    public function getRelatedProducts(Collection $cats, $quantity = 6);
}
