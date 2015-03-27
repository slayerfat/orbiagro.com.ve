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
              <a href="#">
                <img class="media-object" src="{!! $product->images()->first()->path !!}" alt="..." width="128" height="128">
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading">{!! $product->title !!}</h4>
              {!! $product->description !!}
            </div>
          </div>
        </div>
      @endforeach
      {!! $products->render() !!}
    @endunless
  </div>
@stop
