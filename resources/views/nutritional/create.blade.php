@extends('master')

@section('title')
  - Crear - Valores Nutricionales - {{$product->title}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear Valores Nutricionales del Producto {{$product->title}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($nutritional, [
              'action' => ['NutritionalsController@store', $product->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('nutritional.forms.create', ['textoBotonSubmit' => 'Añadir Valores Nutricionales'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
