@extends('master')

@section('title')
  - Actualizar - Valores Nutricionales - {{ $nutritional->product->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Valores Nutricionales</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($nutritional, [
              'method' => 'PATCH',
              'action' => ['NutritionalsController@update', $nutritional->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('nutritional.forms.create', ['textoBotonSubmit' => 'Actualizar Valores Nutricionales'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
