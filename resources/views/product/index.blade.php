@extends('master')

@section('title')
  - Index - Productos
@stop

@section('content')

  @unless(Request::input('page'))
    {{-- desarrollar --}}

    {{-- TODO --}}
    {{-- categorias, sub-categorias, populares. --}}
  @endif

  <div class="container">
    @unless (!isset($products))
      @foreach ($products as $product)
        <div class="row">
          <div class="media product-media">
            <div class="media-left product-image-container">
              <a href="{!! action('ProductsController@show', $product->id) !!}">
                <img
                  class="media-object product-image"
                  src="{!! asset($product->images()->first()->path) !!}"
                  alt="{{ $product->images()->first()->alt }}"
                  width="128" height="128">
              </a>
            </div>
            <div class="media-body product-details-container">
              <a href="{!! action('ProductsController@show', $product->id) !!}">
                <h4 class="media-heading">{{ $product->title }}</h4>
              </a>
              <div class="col-md-3 product-price">
                {{ $product->price_bs() }}
              </div>
              <div class="col-md-9 product-features">
                @if($product->features)
                  @foreach($product->features as $features)
                    <li>{{ $features->title }}</li>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
      {!! $products->render() !!}
    @endunless
  </div>
@stop
