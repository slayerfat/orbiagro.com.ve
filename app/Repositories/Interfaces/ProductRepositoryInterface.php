<?php namespace Orbiagro\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Product;

interface ProductRepositoryInterface
{

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
     * @return mixed
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
}
