<?php namespace Orbiagro\Repositories;

use Orbiagro\Repositories\Interfaces\QuantityTypeRepositoryInterface;

class QuantityTypeRepository extends AbstractRepository implements QuantityTypeRepositoryInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->with('products')->get();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $quantityType = $this->model->newInstance();

        $quantityType->fill($data);

        $quantityType->save();

        return $quantityType;
    }

    /**
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        $quantityType = $this->getById($id);

        $quantityType->fill($data);

        $quantityType->update();

        return $quantityType;
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function delete($id)
    {
        $this->executeDelete($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->pluck('desc', 'id');
    }
}
