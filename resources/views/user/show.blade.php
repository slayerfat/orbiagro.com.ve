@extends('master')

@section('title')
  - Usuario - {{ $user->name }}
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      @include('user.addons.sidebar', ['active' => 'resumen'])
      {{-- user info --}}
      <div class="col-sm-4">
        <h1>
          {{$user->name}}
          <small>
            {!! Html::mailto($user->email) !!}
          </small>
        </h1>
        <h2>
          <small>{{$user->profile->description}}</small>
        </h2>
        @if(Auth::user()->isAdmin() && $user->person)
          <h2>
            {{$user->person->formattedNames()}}
          </h2>
          <h3>
            Cedula: {{$user->person->identity_card}}
          </h3>
          <h3>
            {{$user->person->nationality->description}},
            {{$user->person->gender->description}}
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
