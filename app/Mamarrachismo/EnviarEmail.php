<?php namespace Orbiagro\Mamarrachismo;

use Auth;
use Mail;
use Orbiagro\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * https://github.com/slayerfat/sistemaCONDOR/blob/master/app/Http/Controllers/Otros/EnviarEmail.php
 */
class EnviarEmail
{

    /**
    * la bolsa de correos a ser enviados.
    * @var array
    */
    protected $emails = [];

    /**
     * @var User
     */
    private $users;

    /**
     * Genera una instancia de EnviarEmail
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->users = $user;
    }

    // --------------------------------------------------------------------------
    // Funciones Publicas
    // --------------------------------------------------------------------------

    /**
     * @return array
     */
    public function getAdministratorsEmail()
    {
        return $this->iterateModels($this->getAdmins());
    }

    /**
     * @return array
     */
    public function getAllUsersEmail()
    {
        return $this->iterateModels($this->getAdmins());
    }

    // --------------------------------------------------------------------------
    // Funciones Privadas
    // --------------------------------------------------------------------------

    /**
     * Devuelve una coleccion de los administradores en el sistema.
     *
     * @return Collection
     */
    private function getAdmins()
    {
        return $this->users->admins()->get();
    }

    /**
     * Itera los modelos y revulve un array con sus correos.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     *
     * @return array
     */
    private function iterateModels(Collection $models)
    {
        // logica simplificada por ahora.
        // ver: https://github.com/slayerfat/sistemaCONDOR/blob/master/app/Http/Controllers/Otros/EnviarEmail.php#L27
        foreach ($models as $model) {
            if ($model->email) {
                $this->emails[] = $model->email;
            }
        }

        return $this->emails;
    }

    // --------------------------------------------------------------------------
    // Funciones Estaticas
    // --------------------------------------------------------------------------

    /**
     * Se envia los correos deseados. TEP.
     *
     * @todo ajustarlo a este app.
     *
     * @param  array    $data   el array con los datos relacionados
     * @param  array    $emails
     *
     * @return boolean
     */
    public static function enviarEmail($data, $emails)
    {
        // por si acaso...
        if (!isset($data) && !isset($emails)) {
            return null;
        }

        return Mail::send($data['vista'], $data, function ($message) use ($emails, $data) {
            $message->to($emails)->subject($data['subject']);
        });
    }
}
