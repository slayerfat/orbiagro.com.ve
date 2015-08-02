@extends('master')

@section('title')
  - Actualizar - Proveedor - {{$provider->name}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar {{$provider->name}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($provider, [
              'method' => 'PATCH',
              'action' => ['ProvidersController@update', $provider->id],
              'class'  => 'form-horizontal'
              ]) !!}
              @include('provider.forms.body', ['textoBotonSubmit' => 'Actualizar Fabricante'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
