@extends('master')

@section('title')
  - Actualizar - Productos - {{ $product->title }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Editar {{ $product->title }}</div>
          <div class="panel-body">
            @include('errors.bag')
            {!! Form::model($product, [
                  'method' => 'PATCH',
                  'route' => ['products.update', $product->id],
                  'class'  => 'form-horizontal'
                ]) !!}
              @include('product.forms.edit', ['textoBotonSubmit' => 'Editar Producto'])
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <!-- ajax de edo/mun/par -->
  <script src="{!! asset('js/ajax/setDirecciones.js') !!}"></script>
  <!-- google maps -->
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API') }}">
  </script>
  <script src="{!! asset('js/maps/productMap.js') !!}"></script>
  {{-- CKEDITOR --}}
  <script src="{!! asset('js/vendor/ckeditor/ckeditor.js') !!}"></script>
  <script src="{!! asset('js/editor/products.js') !!}"></script>
@stop
