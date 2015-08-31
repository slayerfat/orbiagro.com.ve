<?php namespace Orbiagro\Repositories;

use Illuminate\Database\QueryException;
use Orbiagro\Models\Provider;
use Orbiagro\Repositories\Interfaces\ProductProviderRepositoryInterface;

class ProductProviderRepository extends AbstractRepository implements ProductProviderRepositoryInterface
{

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->lists('name', 'id');
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
     * @param  mixed $id
     *
     * @return Provider
     */
    public function getById($id)
    {
        return $this->model->with('products')->findOrFail($id);
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
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $provider = $this->getById($id);

        try {
            $provider->delete();
        } catch (\Exception $e) {
            if ($e instanceof QueryException || (int)$e->errorInfo[0] == 23000) {
                return false;
            }
            \Log::error($e);

            abort(500);
        }

        return true;
    }
}
