*******************************************************************
Bienvenido a Orbiagro!
*******************************************************************
Hola! {{ $user->name }}!
*******************************************************************

Para poder ingresar en
{!! link_to_action('HomeController@index', 'orbiagro.com.ve') !!}

Ud. debe confirmar su cuenta a travez del siguiente enlace:

*******************************************************************

{!! action('ConfirmationsController@confirm', $user->confirmation->data) !!}

*******************************************************************
