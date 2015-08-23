@extends('master')

@section('title')
  - Crear - Caracteristicas - {{$product->title}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear Características del Producto {{$product->title}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($characteristic, [
              'route' => ['products.characteristics.store', $product->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('characteristic.forms.body', ['textoBotonSubmit' => 'Añadir Características'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
