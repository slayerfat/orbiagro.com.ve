<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Product;

interface ProductRepositoryInterface
{

    /**
     * @param $id
     *
     * @return bool
     */
    public function canUserManipulate($id);

    /**
     * @param  mixed $id
     * @return Model
     */
    public function getBySlugOrId($id);

    /**
     * @param  mixed $id
     * @return Model
     */
    public function getById($id);

    /**
     * Regresa una coleccion paginada de productos.
     *
     * @param int $perPage el numero por pagina
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginated($perPage);

    /**
     * Checks if user is not disable to create a new product.
     * @return bool
     */
    public function isCurrentUserDisabled();

    /**
     * @return Product
     */
    public function getEmptyInstance();

    /**
     * @param array $data
     * @return Product
     */
    public function store(array $data);

    /**
     * @param $id
     * @param array $data
     * @return Product
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return Product
     */
    public function getByIdWithTrashed($id);

    /**
     * @param string $parent
     * @param int $id
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getByParentSlugOrId($parent, $id);
}
