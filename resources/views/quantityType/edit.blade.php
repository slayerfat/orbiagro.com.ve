@extends('master')

@section('title')
  - Actualizar - Tipo de cantidad - {{$quantityType->desc}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar {{$quantityType->desc}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($quantityType, [
              'method' => 'PATCH',
              'route' => ['quantityTypes.update', $quantityType->id],
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
            @include('quantityType.forms.body', ['textoBotonSubmit' => 'Actualizar Tipo de cantidad'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
