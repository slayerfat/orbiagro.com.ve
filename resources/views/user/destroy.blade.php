@extends('master')

@section('title')
  - Index - {{$user->name}}
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      @include('user.addons.sidebar', ['active' => 'userDestroy'])

      <div class="col-sm-10">
        <h1>UX</h1>
        <h2>DESEA ELIMINAR CUENTA??</h2>
        <p>
          {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
          {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
          {!! Form::close() !!}
        </p>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
