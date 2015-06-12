@extends('master')

@section('title')
  - Usuario - {{ $user->name }}
@stop

@section('content')
  <div class="container">
    <div class="row">
      {{-- user info --}}
      <div class="col-sm-4">
        <h1>
          {{$user->name}}
          <small>
            {{$user->email}}
          </small>
        </h1>
        <h2>
          <small>{{$user->profile->description}}</small>
        </h2>
        @if($user->person)
          <h2>
            {{$user->person->formatted_names()}}
          </h2>
          <h3>
            Cedula: {{$user->person->identity_card}}
          </h3>
          <h3>
            {{$user->person->nationality->description}}, {{$user->person->gender->description}}
          </h3>
          <h3>{{$user->person->phone}}</h3>
        @endif
      </div>

      <div class="col-sm-8">
        <h1>Productos</h1>
        @include('partials.products.simple-media', ['products' => $user->products])
      </div>

    </div>
  </div>
@stop
