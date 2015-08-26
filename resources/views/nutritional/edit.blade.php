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
              'route' => ['products.nutritionals.update', $nutritional->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('nutritional.forms.body', ['textoBotonSubmit' => 'Actualizar Valores Nutricionales'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
