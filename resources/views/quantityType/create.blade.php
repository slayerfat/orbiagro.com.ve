@extends('master')

@section('title')
  - Crear - Tipo de cantidad
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Tipo de cantidad</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($quantityType, [
              'route'  => 'quantityTypes.store',
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
            @include('quantityType.forms.body', ['textoBotonSubmit' => 'Añadir nuevo Tipo de cantidad'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
