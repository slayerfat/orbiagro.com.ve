<?php namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Controllers\Controller;
use Orbiagro\Mamarrachismo\EnviarEmail as Email;
use Auth;
use Orbiagro\Models\User;
use Orbiagro\Models\Profile;
use Orbiagro\Models\UserConfirmation;

class ConfirmationsController extends Controller
{

    /**
     * Comprueba la confirmacion del usuario para ser validado.
     *
     * @param  string $confirmation la cadena de texto a comparar.
     * @return Response
     */
    public function confirm($confirmation)
    {
        if (!$confirmation) {
            return redirect('/');
        }

        $confirmModel = UserConfirmation::where('data', $confirmation)->get();

        if (!$confirmation) {
            return redirect('/');
        }

        if ($confirmModel->count() !== 1) {
            foreach ($confirmModel as $confirm) {
                $confirm->delete();
            }

            return redirect('/');

        } elseif ($confirmModel->count() === 1) {
            $confirmModel = $confirmModel->first();
        }

        $user = User::findOrFail($confirmModel->user_id);

        if (!$user->confirmation) {
            $confirmModel->delete();

            return redirect('/');
        }

        $profile = Profile::where('description', 'Usuario')->first();
        $user->profile_id = $profile->id;
        $user->save();
        $user->confirmation()->delete();

        Auth::logout();
        flash()->success('Ud. ha sido correctamente verificado, por favor ingrese en el sistema.');
        return redirect('auth/login');
    }

    /**
     * Genera una confirmacion y envia un correo electronico al usuario.
     *
     * @return Response
     */
    public function generateConfirm()
    {
        $user = Auth::user();

        if (!$user->confirmation) {
            return redirect('/');
        }

        $confirmation = new UserConfirmation(['data' => true]);
        $user->confirmation()->update(['data' => $confirmation->data]);

        // por alguna razon la confirmacion no se actualiza en el modelo
        // asi que tengo que traermelo otra vez
        $user = User::find(Auth::user()->id);

        // datos usados para enviar el email
        $data = [
            'vista'   => ['emails.confirmation', 'emails.confirmationPlain'],
            'subject' => 'Confirmacion de cuenta en Orbiagro',
            'user'    => $user,
        ];

        // array de destinatarios
        $emails = (array)$user->email;
        Email::enviarEmail($data, $emails);

        flash()->info('Nueva confirmación generada, por favor revise su correo electronico.');
        return redirect('/');
    }
}
