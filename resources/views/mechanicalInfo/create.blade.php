@extends('master')

@section('title')
  - Crear - Informacion Mecanica
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear Información Mecanica</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($mech, [
              'route' => ['products.mechanicals.store', $product->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('mechanicalInfo.forms.body', ['textoBotonSubmit' => 'Añadir Información Mecanica'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
