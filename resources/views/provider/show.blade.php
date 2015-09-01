@extends('master')

@section('title')
  - Crear - Proveedor
@stop

@section('content')

  @if(Auth::user() and Auth::user()->isAdmin())
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_route('providers.edit', 'Editar', $provider->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
        <div class="col-xs-2">
          {!! Form::open(['method' => 'DELETE', 'action' => ['ProvidersController@destroy', $provider->id]]) !!}
          {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  @endif

  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>
          {{$provider->name}} <small>{{$provider->trust}}%</small>
        </h1>
        <h2>
          {{$provider->contact_title}}
          {{$provider->contact_name}}
          {!! Html::mailto($provider->email) !!}
        </h2>
        <h3>
          Telefonos directos del contacto:
          {{$provider->contact_phone_1 ? $provider->contact_phone_1.', ' : null}}
          {{$provider->contact_phone_2 ? $provider->contact_phone_2.', ' : null}}
          {{$provider->contact_phone_3 ? $provider->contact_phone_3.', ' : null}}
          {{$provider->contact_phone_4 ? $provider->contact_phone_4 : null}}
        </h3>
        <h2>{!! Html::mailto($provider->email) !!}</h2>
        <h3>
          Telefonos:
          {{$provider->phone_1 ? $provider->phone_1.', ' : null}}
          {{$provider->phone_2 ? $provider->phone_2.', ' : null}}
          {{$provider->phone_3 ? $provider->phone_3.', ' : null}}
          {{$provider->phone_4 ? $provider->phone_4 : null}}
        </h3>
        <h3>
          <a href="{{$provider->url}}">Pagina Web.</a>
        </h3>
      </div>
    </div>
  </div>

  @unless($provider->products->isEmpty())
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <h1>Productos Asociados a este Proveedor</h1>
            </div>
          </div>
          <div class="row">
            @include('partials.products.gallerie-thumbnail-products', [
              'products' => $provider->products()->random()->get(),
              'size' => 'col-sm-3'
            ])
          </div>
        </div>
      </div>
    </div>
  @endunless
@stop

@section('js')
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
