@extends('master')

@section('title')
  - Crear - Fabricante
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Fabricante</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($provider, [
              'action' => 'ProvidersController@store',
              'class'  => 'form-horizontal'
              ]) !!}
              @include('provider.forms.body', ['textoBotonSubmit' => 'Añadir nuevo Proveedor'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
