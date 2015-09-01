@extends('master')

@section('title')
  - Perfil - {{ $profile->description }}
@stop

@section('content')
  @if(Auth::user() and Auth::user()->isAdmin())
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_route('profiles.edit', 'Editar', $profile->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
        <div class="col-xs-2">
          {!! Form::open(['method' => 'DELETE', 'route' => ['profiles.@destroy', $profile->id]]) !!}
          {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  @endif
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Perfil {{$profile->description}}</h1>
        <h2>Usuarios: {{$profile->users->count()}}</h2>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
