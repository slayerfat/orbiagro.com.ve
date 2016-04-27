<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Provider;
use Orbiagro\Repositories\Interfaces\ProductProviderRepositoryInterface;

class ProductProviderRepository extends AbstractRepository implements ProductProviderRepositoryInterface
{

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->pluck('name', 'id');
    }

    /**
     * @return Provider
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->with('products')->get();
    }

    /**
     * @param array $data
     * @return provider
     */
    public function store(array $data)
    {
        $provider = $this->getNewInstance($data);

        $provider->save();

        return $provider;
    }

    /**
     * @param $id
     * @param array $data
     * @return provider
     */
    public function update($id, array $data)
    {
        $provider = $this->getById($id);

        $provider->fill($data);

        $provider->update();

        return $provider;
    }

    /**
     * @param  mixed $id
     *
     * @return Provider
     */
    public function getById($id)
    {
        return $this->model->with('products')->findOrFail($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        return $this->executeDelete($id, 'Proveedor');
    }
}
