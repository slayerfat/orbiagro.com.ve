@extends('master')

@section('title')
  - Actualizar - Proveedor - {{$product->title}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Proveedor de {{$product->title}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($product, [
              'method' => 'PATCH',
              'action' => ['ProductsProvidersController@update', $product->id.'/'.$providerId],
              'class' => 'form-horizontal',
              ]) !!}
              @include('product.provider.forms.body', ['textoBotonSubmit' => 'Actualizar Proveedor asociado'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
