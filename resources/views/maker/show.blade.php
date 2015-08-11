@extends('master')

@section('content')

  @if(Auth::user() and Auth::user()->isAdmin())
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('MakersController@edit', 'Editar', $maker->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
        <div class="col-xs-2">
          {!! Form::open(['method' => 'DELETE', 'action' => ['MakersController@destroy', $maker->id]]) !!}
          {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  @endif

  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="media">
          <div class="media-body">
            <h1 class="media-heading">{{$maker->name}}</h1>
            <h2>
              <a href="{{$maker->url}}">{{$maker->domain}}</a>
            </h2>
          </div>
          @if($maker->image)
            <div class="media-right">
              <a href="#">
                <img
                  width="128" height="128"
                  class="media-object"
                  src="{{asset($maker->image->path)}}"
                  alt="{{$maker->image->alt}}">
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
    @unless($maker->products->isEmpty())
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <h1>Productos Asociados a este Fabricante</h1>
            </div>
          </div>
          <div class="row">
            @include('partials.products.gallerie-thumbnail-products', [
              'products' => $maker->products()->random()->take(20)->get(),
              'size' => 'col-sm-3'
            ])
          </div>
        </div>
      </div>
    @endunless
  </div>
@stop

@section('js')
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
