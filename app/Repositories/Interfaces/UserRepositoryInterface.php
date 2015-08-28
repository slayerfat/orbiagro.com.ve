<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
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
