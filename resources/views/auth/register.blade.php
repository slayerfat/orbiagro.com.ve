@extends('master')

@section('title')
  - Registrarse
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Registrarse en Orbiagro</div>
        <div class="panel-body">
          @include('errors.bag')
          @include('auth._form')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
