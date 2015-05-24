@extends('master')

@section('title')
  - Crear - Distintivo - {{$product->title}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Distintivo</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($feature, [
              'action' => ['FeaturesController@store', $product->id],
              'class' => 'form-horizontal',
              'files' => true,
              ]) !!}
              @include('feature.forms.body', ['textoBotonSubmit' => 'Añadir nuevo Distintivo'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
