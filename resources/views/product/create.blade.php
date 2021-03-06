@extends('master')

@section('title')
  - Crear - Productos
@stop

@section('css')
  <link rel="stylesheet" href="{!! asset('css/vendor/cropper.min.css') !!}" charset="utf-8">
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
              'route' => 'products.store',
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
  <script src="{!! asset('js/editor/ckEditor.js') !!}"></script>
  <script type="text/javascript">
    startEditor('product-description', 'replace');
  </script>
  {{-- image upload / crop --}}
  <script src="{!! asset('js/vendor/cropper.min.js') !!}"></script>
@stop
