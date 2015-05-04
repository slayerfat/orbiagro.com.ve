@extends('master')

@section('title')
  - Index - Productos
@stop

@section('content')

  @unless(Request::input('page'))
    <div class="container">
      <div class="row">
        @include('category.addons.gallery-slick', ['title' => 'Categorias', 'cats' => $cats])
      </div>
      <div class="row">
        @include('category.addons.gallery-slick', ['title' => 'Sub-Categorias', 'cats' => $subCats])
      </div>
    </div>

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

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-cats').slick({
        autoplay: false,
        autoplaySpeed: 2000,
        dots: true,
        arrows:false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: false,
        variableWidth: true
      });
    });
  </script>
@stop
