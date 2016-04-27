@extends('master')

@section('content')

  @if(Auth::user() and Auth::user()->isAdmin())
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_route('quantityTypes.edit', 'Editar', $quantityType->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
        <div class="col-xs-2">
          {!! Form::open(['method' => 'DELETE', 'route' => ['quantityTypes.destroy', $quantityType->id]]) !!}
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
            <h1 class="media-heading">{{$quantityType->desc}}</h1>
          </div>
        </div>
      </div>
    </div>
    @unless($quantityType->products->isEmpty())
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <h1>Productos Asociados a este Tipo de cantidad</h1>
            </div>
          </div>
          <div class="row">
            @include('partials.products.gallerie-thumbnail-products', [
              'products' => $quantityType->products()->random()->take(20)->get(),
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
