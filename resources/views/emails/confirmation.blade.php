@extends('emails.structure')

@section('content')
  <section style="color: #333;font-family: sans-serif;">
    <h1>Bienvenido a Orbiagro!</h1>
    <h3>
      Hola! {{ $user->name }}!
    </h3>
  </section>
  <section style="color: #333;font-family: sans-serif;">
    <p id="body" style="text-align: justify;">
      Para poder ingresar en
      {!! link_to_action('HomeController@index', 'orbiagro.com.ve') !!}
      Ud. debe confirmar su cuenta a travez del siguiente enlace:
    </p>
    <p>
      <?php $url = action('ConfirmationsController@confirm', $user->confirmation->data) ?>
      <a href="{{ $url }}">{{ $url }}</a>
    </p>
  </section>
@stop
