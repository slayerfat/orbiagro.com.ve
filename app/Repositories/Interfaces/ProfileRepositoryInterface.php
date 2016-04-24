<?php namespace Orbiagro\Repositories\Interfaces;

use Orbiagro\Models\Profile;

interface ProfileRepositoryInterface
{

    /**
     * @param string $id
     * @return Profile
     */
    public function getByDescription($id);

    /**
     * @param  int $id
     * @return Profile
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
     * @return Profile
     */
    public function getEmptyInstance();

    /**
     * @param array $data
     * @return Profile
     */
    public function store(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return Profile
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function destroy($id);

    /**
     * @return array
     */
    public function getLists();
}
