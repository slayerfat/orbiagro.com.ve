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
      <div class='slider-sync col-md-5'>
        <div class="row">
          <div class="col-xs-12">
            <h2>
              <strong>{{ $product->price_bs() }}</strong>
            </h2>
            <p>
              {{ $product->quantity }} Unidades
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-xm-12">
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
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p>
          Creado el: {{ $product->created_at }}
          Actualizado el: {{ $product->updated_at }}
        </p>
      </div>
    </div>
  </div>

  <?php $sub_category = $product->sub_category ?>
  @include('sub-category.addons.relatedProducts', [$sub_category, 'title' => 'Productos Relacionados'])

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2>Especificaciones</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6" id="features">
        @include('product.addons.features', $product)
      </div>
      <div class="col-sm-6">
        @include('product.addons.mechanical', $product)
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        @include('product.addons.characteristics', $product)
      </div>
      <div class="col-sm-6">
        @include('product.addons.nutritional', $product)
      </div>
    </div>
  </div>

  @include('product.addons.direction', $product)

  @include('visit.addons.gallerie-products')

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
