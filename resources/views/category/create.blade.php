@extends('master')

@section('title')
  - Crear - Categoria
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nueva Categoria</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($cat, [
              'action' => 'CategoriesController@store',
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
              @include('category.forms.body', ['textoBotonSubmit' => 'Añadir nueva Categoria'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
