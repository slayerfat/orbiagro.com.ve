@extends('master')

@section('title')
  Index - Perfil
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        @foreach($profiles as $profile)
          <h1>{!! link_to_action('ProfilesController@show', $profile->description, $profile->id) !!}</h1>
          <h2>Usuarios: {{$profile->users->count()}}</h2>
        @endforeach
        {!! $profiles->render() !!}
      </div>
    </div>
  </div>
@stop
