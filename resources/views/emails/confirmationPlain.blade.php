*******************************************************************
Bienvenido a Orbiagro!
*******************************************************************
Hola! {{ $user->name }}!
*******************************************************************

Para poder ingresar en
{!! link_to_route('home', 'orbiagro.com.ve') !!}

Ud. debe confirmar su cuenta a travez del siguiente enlace:

*******************************************************************

{!! route('users.confirmations.confirm', $user->confirmation->data) !!}

*******************************************************************
