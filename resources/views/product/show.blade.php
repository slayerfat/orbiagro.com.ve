@extends('master')

@section('content')

  @if(Auth::user() and Auth::user()->isOwnerOrAdmin($product->user_id))
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('ProductsController@edit', 'Editar', $product->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
      </div>
    </div>
  @endif

  @include('product.breadcrumbs', $product)
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1>{{ $product->title }}</h1>
        <p>
          Por: {!! link_to_action('MakersController@show', $product->maker->name, $product->maker->slug) !!}
        </p>
        <p id="product-description">
          {!! $product->description !!}
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
        <p class="product-dates">
          Creado
          {!! Date::parse($product->created_at)->diffForHumans() !!}.
          @unless($product->created_at == $product->updated_at)
            <i>
              Ultima actualizacion
              {!! Date::parse($product->updated_at)->diffForHumans() !!}.
            </i>
          @endunless
        </p>
        <p>
          {!! link_to_action('SubCategoriesController@show', 'Producto en el Rubro '.$product->sub_category->description,$product->sub_category->slug ) !!}
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
      <div class="col-sm-6">
        @include('product.addons.characteristics', $product)
      </div>
      <div class="col-sm-6">
        @include('product.addons.mechanical', $product)
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        @include('product.addons.nutritional', $product)
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12" id="features">
        @include('product.addons.features', $product)
      </div>
    </div>
  </div>

  @include('product.addons.direction', $product)

  @include('visit.addons.relatedProducts')

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
  {{-- galeria de productos visitados relacionados. --}}
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
  {{-- CKEDITOR --}}
  <script src="{!! asset('js/vendor/ckeditor/ckeditor.js') !!}"></script>
  <script src="{!! asset('js/editor/products.js') !!}"></script>
@stop
