@extends('master')

@section('title')
  - Actualizar - Perfil - {{$profile->description}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Perfil {{$profile->description}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($profile, [
              'method' => 'PATCH',
              'action' => ['ProfilesController@update', $profile->id],
              'class'  => 'form-horizontal',
              ]) !!}
              @include('profile.forms.body', ['textoBotonSubmit' => 'Actualizar Perfil'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
