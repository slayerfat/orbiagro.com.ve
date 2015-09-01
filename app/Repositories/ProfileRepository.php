<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Profile;
use Orbiagro\Repositories\Exceptions\InvalidProfileRequestException;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{

    /**
     * @param string $id
     * @return Profile
     */
    public function getByDescription($id)
    {
        return $this->getByIdOrAnother($id, 'description');
    }

    /**
     * @param int $perPage el numero por pagina
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginated($perPage)
    {
        return $this->model->with('users')->paginate($perPage);
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->model->lists('description', 'id');
    }

    /**
     * @param $data
     * @return Profile
     */
    public function store(array $data)
    {
        $profile = $this->model->newInstance();

        $profile->fill($data);

        $profile->save();

        return $profile;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Profile
     */
    public function update($id, array $data)
    {
        $profile = $this->getById($id);

        $profile->fill($data);

        $profile->update();

        return $profile;
    }

    /**
     * @param $id
     * @return bool|null
     * @throws InvalidProfileRequestException
     */
    public function destroy($id)
    {
        if ($id <= 3) {
            throw new InvalidProfileRequestException('Los perfiles principales no pueden ser eliminados.');
        }

        $profile = $this->getById($id);

        if (!$profile->users->isEmpty()) {
            return false;
        }

        return $profile->delete();
    }

    /**
     * @return Profile
     */
    public function getEmptyInstance()
    {
        return $this->getNewInstance();
    }
}
