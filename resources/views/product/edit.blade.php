@extends('master')

@section('title')
  - Actualizar - Productos - {{ $product->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Editar {{ $product->title }}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($product, [
                  'method' => 'PATCH',
                  'action' => ['ProductsController@update', $product->id],
                  'class'  => 'form-horizontal'
                ]) !!}
              @include('product.addons.form', ['textoBotonSubmit' => 'Editar Producto'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
