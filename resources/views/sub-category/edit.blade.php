@extends('master')

@section('title')
  - Actualizar - Rubro - {{ $subCat->description }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar {{$subCat->description}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($subCat, [
              'method' => 'PATCH',
              'route' => ['subCats.update', $subCat->id],
              'class'  => 'form-horizontal',
              'files'  => true
              ]) !!}
              @include('sub-category.forms.body', ['textoBotonSubmit' => 'Actualizar Rubro'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
