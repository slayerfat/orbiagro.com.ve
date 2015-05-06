@extends('master')

@section('title')
  - Crear - Productos
@stop

@section('css')
  <link rel="stylesheet" href="{!! asset('css/vendor/picEdit/picedit.min.css') !!}" charset="utf-8">
@stop
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Crear nuevo Producto</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($product, [
              'action' => 'ProductsController@store',
              'class' => 'form-horizontal',
              'files' => true
              ]) !!}
              @include('product.forms.create', ['textoBotonSubmit' => 'Añadir nuevo Producto'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <!-- ajax de edo/mun/par -->
  <script src="{!! asset('js/ajax/getDirecciones.js') !!}"></script>
  <!-- google maps -->
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}">
  </script>
  <script src="{!! asset('js/maps/productMap.js') !!}"></script>
  {{-- CKEDITOR --}}
  <script src="{!! asset('js/vendor/ckeditor/ckeditor.js') !!}"></script>
  <script src="{!! asset('js/editor/products.js') !!}"></script>
  {{-- image upload / crop --}}
  <script src="{!! asset('js/vendor/picEdit/picedit.min.js') !!}"></script>
  <script type="text/javascript">
    $(function() {
      $('#images').picEdit();
    });
  </script>
@stop
