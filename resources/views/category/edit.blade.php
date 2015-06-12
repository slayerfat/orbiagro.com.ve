@extends('master')

@section('title')
  - Actualizar - Categoria - {{ $cat->description }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar {{$cat->description}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($cat, [
              'method' => 'PATCH',
              'action' => ['CategoriesController@update', $cat->id],
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
              @include('category.forms.body', ['textoBotonSubmit' => 'Actualizar Categoria'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
