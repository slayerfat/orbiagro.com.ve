<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Model;
use LogicException;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\Exceptions\DuplicateConfirmationException as DuplicateException;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;
use Orbiagro\Repositories\Interfaces\UserConfirmationInterface;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;

class UserConfirmationRepository extends AbstractRepository implements UserConfirmationInterface
{

    /**
     * @var UserConfirmation
     */
    protected $model;

    /**
     * @var ProfileRepositoryInterface
     */
    private $profile;

    /**
     * @var UserRepositoryInterface
     */
    private $user;

    /**
     * @param UserRepositoryInterface $user
     * @param ProfileRepositoryInterface $profile
     * @param Model $model
     */
    public function __construct(
        UserRepositoryInterface $user,
        ProfileRepositoryInterface $profile,
        Model $model
    ) {
        $this->user = $user;

        $this->profile = $profile;

        parent::__construct($model);
    }

    /**
     * @return Model|\Orbiagro\Models\User
     * @throws LogicException
     */
    public function create()
    {
        $user = $this->getCurrentUser();

        if (is_null($user)) {
            throw new LogicException('Se necesita el usuario para crear Confirmacion.');
        }

        $confirmation = $this->getNewInstance(['data' => true]);

        $user->confirmation()->save($confirmation);

        return $user;
    }

    /**
     * @param $data
     * @return Model|null
     * @throws DuplicateException
     */
    public function getConfirmation($data)
    {
        $confirmModel = $this->model->whereData($data)->get();

        if ($confirmModel->count() === 1) {
            return $confirmModel->first();

        } elseif ($confirmModel->count() > 1) {
            $confirmModel->each(function (UserConfirmation $confirm) {
                $confirm->delete();
            });

            throw new DuplicateException('Existen Confirmaciones Duplicadas en el sistema.');
        }

        return null;
    }

    /**
     * @param Model $model
     * @return null|\Orbiagro\Models\User
     * @throws \Exception
     * @throws LogicException
     */
    public function validateUser(Model $model)
    {
        $user = $this->getCurrentUser();

        if ($user->id != $model->user_id) {
            return null;
        }

        if (is_null($user->confirmation)) {
            $model->delete();

            throw new LogicException(
                'El usuario '
                . $user->name
                . 'Correo: ' . $user->email
                . ' no posee Confirmacion.'
            );
        }

        $profile = $this->profile->getByDescription('Usuario');

        $user->profile_id = $profile->id;

        $user->save();

        $user->confirmation()->delete();

        return $user;
    }
}
