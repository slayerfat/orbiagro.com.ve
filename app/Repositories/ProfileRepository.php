<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Profile;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{

    /**
     * @param string $desc
     *
     * @return Profile
     */
    public function getByDescription($desc)
    {
        return $this->getByIdOrAnother($desc, 'description');
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
     * @param $data
     * @return Profile
     */
    public function store(array $data)
    {
        $profile = $this->getEmptyInstance();

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
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($id <= 3) {
            throw new \Exception('Los perfiles principales no pueden ser eliminados.');
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
