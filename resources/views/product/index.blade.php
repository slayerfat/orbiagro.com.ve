@extends('master')

@section('title')
  - Index - Productos
@stop

@section('content')
  <div class="container">
    @unless (!isset($products))
      @foreach ($products as $product)
        <div class="row">
          <div class="media">
            <div class="media-left">
              <a href="{!! action('ProductsController@show', $product->id) !!}">
                <img
                  class="media-object"
                  src="{!! asset($product->images()->first()->path) !!}"
                  alt="{{ $product->images()->first()->alt }}"
                  width="128" height="128">
              </a>
            </div>
            <div class="media-body">
              <a href="{!! action('ProductsController@show', $product->id) !!}">
                <h4 class="media-heading">{{ $product->title }}</h4>
              </a>
              {{ $product->description }}
            </div>
          </div>
        </div>
      @endforeach
      {!! $products->render() !!}
    @endunless
  </div>
@stop
