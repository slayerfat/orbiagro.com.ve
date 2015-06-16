@extends('master')

@section('title')
  - Usuario - {{ $user->name }}
@stop

@section('content')
  {{-- @if(Auth::user() and Auth::user()->isAdmin())
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('UsersController@edit', 'Editar', $user->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
      </div>
    </div>
  @endif --}}
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-2 sidebar">
        <ul class="nav nav-sidebar">
          <li class="active">
            <a href="#">Resumen</a>
          </li>
          <li>
            <a href="#">Información Personal</a>
          </li>
          <li>
            <a href="#">Seguridad</a>
          </li>
          <li>
            <a href="#">Productos</a>
          </li>
          <li>
            <a href="#">Facturación</a>
          </li>
        </ul>
      </div>
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
      {{-- productos --}}
      @unless($products->isEmpty())
        <div class="col-sm-6">
          <h1>Productos</h1>
          @include('partials.products.paginated', ['products' => $products])
        </div>
      @else
        <h1>TODO: CREAR PRODUCTO?</h1>
      @endunless
    </div>
  </div>
@stop
