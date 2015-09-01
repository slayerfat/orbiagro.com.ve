@extends('master')

@section('title')
  - Crear - Valores Nutricionales - {{$product->title}}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear Valores Nutricionales del Producto {{$product->title}}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($nutritional, [
              'route' => ['products.nutritionals.store', $product->id],
              'class' => 'form-horizontal',
              ]) !!}
              @include('nutritional.forms.body', ['textoBotonSubmit' => 'Añadir Valores Nutricionales'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

{{-- se mete directamente aqui porque ambas formas poseen el mismo codigo --}}
@section('css')
  <link href="{!! asset('css/vendor/datepicker.css') !!}" rel="stylesheet">
@endsection

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/bootstrap-datepicker.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/vendor/bootstrap-datepicker.es.js') !!}"></script>
  <script type="text/javascript">
    $('#due').datepicker({
      language: 'es',
      format: 'yyyy-mm-dd'
    });
  </script>
@stop
