@extends('master')

@section('title')
  - Actualizar - Distitivo - {{ $feature->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Distintivo</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($feature, [
              'method' => 'PATCH',
              'route' => ['products.features.update', $feature->id],
              'class' => 'form-horizontal',
              'files' => true,
              ]) !!}
              @include('feature.forms.body', ['textoBotonSubmit' => 'Actualizar Distintivo'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
