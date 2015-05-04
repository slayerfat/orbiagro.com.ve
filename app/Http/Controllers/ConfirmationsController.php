<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mamarrachismo\EnviarEmail as Email;
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
    $confirmModel = UserConfirmation::where('data', $confirmation)->get();
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
    $user = User::findOrFail($confirmModel->user_id);
    if (!$user->confirmation) :
      $confirmModel->delete();
      return redirect('/');
    endif;
    $profile = Profile::where('description', 'Usuario')->first();
    $user->profile_id = $profile->id;
    $user->save();
    $user->confirmation()->delete();
    Auth::logout();
    flash()->success('Ud. ha sido correctamente verificado, por favor ingrese en el sistema.');
    return redirect('auth/login');
  }

  public function generateConfirm()
  {
    $user = Auth::user();
    if (!$user->confirmacion):
      return redirect('/');
    endif;
    $confirmation = new UserConfirmation(['data' => true]);
    $user->confirmation()->update(['data' => $confirmation->data]);
    // por alguna razon la confirmacion no se actualiza en el modelo
    // asi que tengo que traermelo otra vez
    $user = User::find(Auth::user()->id);
    // datos usados para enviar el email
    $data = [
      'vista'   => ['emails.confirmation', 'emails.confirmationPlain'],
      'subject' => 'Confirmacion de cuenta en Orbiagro',
      'user' => $user,
    ];
    // array de destinatarios
    $emails = (array)$user->email;
    Email::enviarEmail($data, $emails);
    flash('Nueva confirmacion generada, por favor revise su correo electronico.');
    return redirect('/por-verificar');
  }
}
