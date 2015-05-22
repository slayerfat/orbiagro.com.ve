@extends('master')

@section('title')
  - Crear - Feature
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Producto</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($product, [
              'action' => ['FeaturesController@store', $product->id],
              'class' => 'form-horizontal',
              'files' => true,
              ]) !!}
              @include('feature.forms.create', ['textoBotonSubmit' => 'Añadir nuevo Feature'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
