<?php namespace Orbiagro\Repositories;

use Auth;
use LogicException;
use Orbiagro\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\Exceptions\DuplicateConfirmationException;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;
use Orbiagro\Repositories\Interfaces\UserConfirmationInterface;

class UserConfirmationRepository extends AbstractRepository implements UserConfirmationInterface
{

    /**
     * @param UserRepositoryInterface $user
     * @param Model                   $model
     */
    public function __construct(UserRepositoryInterface $user, Model $model)
    {
        parent::__construct($model);

        $this->user = $user;
    }

    /**
     * @return Model
     */
    public function create()
    {
        $user = Auth::user();

        if (is_null($user)) {
            throw new LogicException('Se necesita el usuario para crear Confirmacion.');
        }

        $confirmation = new UserConfirmation(['data' => true]);

        $user->confirmation()->save($confirmation);

        return $user;
    }

    /**
     * @param string $data
     *
     * @return Model|null
     * @throws DuplicateConfirmationException
     */
    public function getConfirmation($data)
    {
        $confirmModel = $this->model->whereData($data)->get();

        if ($confirmModel->count() === 1) {
            return $confirmModel->first();

        } elseif ($confirmModel->count() > 1) {
            foreach ($confirmModel as $confirm) {
                $confirm->delete();
            }
        }

        throw new DuplicateConfirmationException('Existen Confirmacion Duplicadas en el sistema.');
    }

    /**
     * @param Model $model
     *
     * @return null|\Orbiagro\Models\User
     * @throws \Exception
     * @throws LogicException
     */
    public function validateUser(Model $model)
    {
        $user = Auth::user();

        if ($user->id != $model->user_id) {
            return null;
        }

        if (!$user->confirmation) {
            $model->delete();

            throw new LogicException('El usuario '.$user.' no posee confirmacion Confirmacion.');
        }

        $profile = Profile::whereDescription('Usuario')->first();

        $user->profile_id = $profile->id;

        $user->save();

        $user->confirmation()->delete();

        return $user;
    }
}
