<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Models\Promotion;

interface PromotionRepositoryInterface
{
    /**
     * @param  mixed $id
     *
     * @return Promotion
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Promotion
     */
    public function getById($id);

    /**
     * @return Collection
     */
    public function getHomeRelated();
}
