<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Otros\EnviarEmail as Email;
use Auth;
use App\User;
use App\Profile;
use App\UserConfirmation;
use Illuminate\Http\Request;

class ConfirmationsController extends Controller {

  public function confirm($confirmation)
  {
    if ( !$confirmation ) :
      return redirect('/');
    endif;
    $confirmModel = UserConfirmation::where('confirmation', $confirmation)->get();
    if ( !$confirmModel ) :
      return redirect('/');
    endif;
    if ( $confirmModel->count() !== 1 ) :
      foreach($confirmModel as $confirm):
        $confirm->delete();
      endforeach;
      return redirect('/');
    else:
      $confirmModel = $confirmModel->first();
    endif;
    $usuario = User::findOrFail($confirmModel->user_id);
    if (!$usuario->confirmacion) :
      $confirmModel->delete();
      return redirect('/');
    endif;
    $perfil = Profile::where('description', 'Sin Edificio')->first();
    $usuario->profile_id = $perfil->id;
    $usuario->save();
    $usuario->confirmacion()->delete();
    Auth::logout();
    flash()->success('Ud. ha sido correctamente verificado, por favor ingrese en el sistema.');
    return redirect('auth/login');
  }

  public function generateConfirm()
  {
    $usuario = Auth::user();
    if (!$usuario->confirmacion):
      return redirect('/');
    endif;
    $confirmacion = new UserConfirmation(['confirmation' => true]);
    $usuario->confirmacion()->update(['confirmation' => $confirmacion->confirmation]);
    // por alguna razon la confirmacion no se actualiza en el modelo
    // asi que tengo que traermelo otra vez
    $usuario = User::find(Auth::user()->id);
    // datos usados para enviar el email
    $data = [
      'vista'   => ['emails.confirmation', 'emails.confirmationPlain'],
      'subject' => 'Confirmacion de cuenta en sistemaCONDOR',
      'usuario' => $usuario,
    ];
    // array de destinatarios
    $emails = (array)$usuario->email;
    Email::enviarEmail($data, $emails);
    flash('Nueva confirmacion generada, por favor revise su correo electronico.');
    return redirect('/por-verificar');
  }
}
