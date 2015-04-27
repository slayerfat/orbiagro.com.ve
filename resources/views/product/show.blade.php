@extends('master')

@section('title')
  - Index - Productos
@stop

@section('content')
  @include('product.breadcrumbs', $product)
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1>{{ $product->title }}</h1>
        <p>
          {{ $product->description }}
        </p>

      </div>
      <div class='container slider-sync col-md-5'>
        <div class="slider slider-for">
          @foreach ($product->images as $image)
            <div>
              <img
                src="{!! asset($image->path) !!}"
                alt="{{ $image->alt }}"
                class="img-responsive"/>
            </div>
          @endforeach
        </div>
        <div class="slider slider-nav">
          @foreach ($product->images as $image)
            <div>
              <img
                src="{!! asset($image->path) !!}"
                alt="{{ $image->alt }}"
                class="img-responsive"/>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        @include('product.addons.characteristics', $product)
      </div>
    </div>
  </div>

  @include('partials.disclaimer')
@stop

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>
  <script charset="utf-8">
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      dots: true,
      centerMode: true,
      focusOnSelect: true
    });
  </script>
@stop
