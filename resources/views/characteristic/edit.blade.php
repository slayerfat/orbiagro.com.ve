@extends('master')

@section('title')
  - Actualizar - Caracteristicas - {{ $characteristic->product->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Actualizar Características</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($characteristic, [
              'method' => 'PATCH',
              'route' => ['products.characteristics.update', $characteristic->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('characteristic.forms.body', ['textoBotonSubmit' => 'Actualizar Características'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
