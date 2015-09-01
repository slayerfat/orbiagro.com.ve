@extends('master')

@section('title')
  - Actualizar - Usuario - {{$user->name}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Usuario {{$user->name}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($user, [
              'method' => 'PATCH',
              'route' => ['users.update', $user->id],
              'class'  => 'form-horizontal',
              ]) !!}
              @include('user.forms.body', ['textoBotonSubmit' => 'Actualizar Usuario'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
