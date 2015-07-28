@extends('master')

@section('title')
  - Crear - Proveedor - {{$product->title}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Asociar Proveedor al Producto {{$product->title}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::open([
              'action' => ['ProductsProvidersController@store', $product->id],
              'class'  => 'form-horizontal'
              ]) !!}
              @include('product.provider.forms.body', ['textoBotonSubmit' => 'Añadir Proveedor'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
