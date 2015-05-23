@extends('master')

@section('title')
  - Actualizar - Feature - {{ $feature->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Feature</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($feature, [
              'method' => 'PATCH',
              'action' => ['FeaturesController@update', $feature->id],
              'class' => 'form-horizontal',
              'files' => true,
              ]) !!}
              @include('feature.forms.create', ['textoBotonSubmit' => 'Actualizar Feature'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
