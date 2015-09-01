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
