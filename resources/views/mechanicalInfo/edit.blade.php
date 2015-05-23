@extends('master')

@section('title')
  - Actualizar - Informacion Mecanica - {{ $mech->product->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Producto</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($mech, [
              'method' => 'PATCH',
              'action' => ['MechanicalInfoController@update', $mech->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('mechanicalInfo.forms.create', ['textoBotonSubmit' => 'Actualizar Informacion Mecanica'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
