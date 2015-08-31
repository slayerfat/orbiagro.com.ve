<?php namespace Orbiagro\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use LogicException;
use Orbiagro\Models\Maker;
use Orbiagro\Repositories\Interfaces\MakerRepositoryInterface;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MakerRepository extends AbstractRepository implements MakerRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAll()
    {
        return $this->model->with('products')->get();
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->lists('name', 'id');
    }

    /**
     * @return Maker
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }

    /**
     * @param array $data
     *
     * @return Maker
     */
    public function create(array $data)
    {
        $model = $this->getEmptyInstance();

        if ($model->save($data)) {
            return $model;
        }

        throw new LogicException('Datos no fueron procesados por el MakerRequest, no se salvo el modelo.');
    }

    /**
     * @param       $id
     * @param array $data
     *
     * @return Maker
     */
    public function update($id, array $data)
    {
        $maker = $this->getBySlugOrId($id);

        $maker->update($data);

        $maker->load('image');

        return $maker;
    }

    /**
     * @param $id
     * @return void
     * @throws HttpException
     */
    public function delete($id)
    {
        $this->executeDelete($id, 'Fabricante', 'Productos');
    }
}
