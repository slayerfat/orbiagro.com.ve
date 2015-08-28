<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getById($id);
}
