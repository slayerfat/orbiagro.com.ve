@extends('master')

@section('title')
  - Actualizar - Fabricante - {{$maker->name}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar {{$maker->name}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($maker, [
              'method' => 'PATCH',
              'route' => ['makers.update', $maker->id],
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
              @include('maker.forms.body', ['textoBotonSubmit' => 'Actualizar Fabricante'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
