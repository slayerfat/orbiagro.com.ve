@extends('master')

@section('title')
  - Crear - Perfil
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Perfil</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($profile, [
              'route' => 'profiles.store',
              'class'  => 'form-horizontal',
              ]) !!}
              @include('profile.forms.body', ['textoBotonSubmit' => 'Añadir nuevo Perfil'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
