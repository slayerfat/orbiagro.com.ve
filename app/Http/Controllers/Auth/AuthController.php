<?php namespace Orbiagro\Http\Controllers\Auth;

use Orbiagro\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
// 5.1
use Orbiagro\Models\User;
use Orbiagro\Models\Profile;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Mamarrachismo\EnviarEmail as Email;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

/**
 * Class AuthController
 * @package Orbiagro\Http\Controllers\Auth
 */
class AuthController extends Controller
{

    /**
     * Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers
     * @redirectPath()
     *
     * @var string
     */
    protected $redirectTo = '/';

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        $profile      = Profile::where('description', 'Desactivado')->firstOrFail();
        $confirmation = new UserConfirmation(['data' => true]);

        // nuevo usuario
        $user = new User;
        $user->name       = $data['name'];
        $user->profile_id = $profile->id;
        $user->email      = $data['email'];
        $user->password   = bcrypt($data['password']);
        $user->save();
        $user->confirmation()->save($confirmation);

        // datos usados para enviar el email
        $data = [
            'vista'   => ['emails.confirmation', 'emails.confirmationPlain'],
            'subject' => 'Confirmacion de cuenta en orbiagro.com.ve',
            'user'    => $user,
        ];

        // array de destinatarios
        $emails = (array)$user->email;
        Email::enviarEmail($data, $emails);

        flash()->info(
            'Usuario creado exitosamene, un correo de confirmación '
            .'ha sido enviado a '
            .$user->email
        );

        return $user;
    }

    /**
     * Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers
     * @getFailedLoginMessage()
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Los datos suministrados no concuerdan con nuestros archivos.';
    }
}
