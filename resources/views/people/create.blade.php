@extends('master')

@section('title')
  - Crear - Informacion Personal - {{$user->name}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear Información Personal para {{$user->name}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($person, [
              'action' => ['PeopleController@store', $user->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('people.forms.body', ['textoBotonSubmit' => 'Añadir Información Personal'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
