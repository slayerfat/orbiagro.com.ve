<?php namespace Orbiagro\Http\Controllers;

use Auth;
use Illuminate\Http\RedirectResponse;
use Orbiagro\Mamarrachismo\EnviarEmail as Email;
use Orbiagro\Repositories\Interfaces\UserConfirmationInterface;

class ConfirmationsController extends Controller
{

    private $confirm;

    /**
     * @param UserConfirmationInterface $confirm
     */
    public function __construct(UserConfirmationInterface $confirm)
    {
        $this->confirm = $confirm;
    }

    /**
     * Comprueba la confirmacion del usuario para ser validado.
     *
     * @param  string $confirmation la cadena de texto a comparar.
     * @return RedirectResponse
     */
    public function confirm($confirmation)
    {
        if (!$confirmation || trim($confirmation) == '') {
            return redirect('/');
        }

        $confirmModel = $this->confirm->getConfirmation($confirmation);

        if (is_null($confirmModel)) {
            return redirect('/');
        }

        $user = $this->confirm->validateUser($confirmModel);

        if (is_null($user)) {
            return redirect('/');
        }

        Auth::logout();

        flash()->success('Ud. ha sido correctamente verificado, por favor ingrese en el sistema.');

        return redirect('auth/login');
    }

    /**
     * Genera una confirmacion y envia un correo electronico al usuario.
     *
     * @return RedirectResponse
     */
    public function createConfirm()
    {
        $user = $this->confirm->create();

        // datos usados para enviar el email
        $data = [
            'vista'   => ['emails.confirmation', 'emails.confirmationPlain'],
            'subject' => 'Confirmacion de cuenta en Orbiagro',
            'user'    => $user,
        ];

        // array de destinatarios
        $emails = (array)$user->email;
        Email::enviarEmail($data, $emails);

        flash()->info(
            'Nueva confirmación generada y enviada a '
            .$user->email
            .', por favor revise su correo electronico.'
        );

        return redirect('/');
    }
}
