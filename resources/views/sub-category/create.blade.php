@extends('master')

@section('title')
  - Crear - Rubro
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Rubro</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($subCat, [
              'action' => 'SubCategoriesController@store',
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
              @include('sub-category.forms.body', ['textoBotonSubmit' => 'Añadir nuevo Rubro'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
