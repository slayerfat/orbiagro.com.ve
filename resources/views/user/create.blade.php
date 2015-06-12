@extends('master')

@section('title')
  - Crear - Usuario
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Usuario</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($user, [
              'action' => 'UsersController@store',
              'class'  => 'form-horizontal',
              ]) !!}
              @include('user.forms.body', ['textoBotonSubmit' => 'Añadir nuevo Usuario'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
