@extends('master')

@section('content')

  @if(preg_match('/rubros\//', Request::path()))
    <?php $productsTitle = "Productos en {$products->first()->subCategory->description}" ?>
    @include('product.addons.breadcrumbs-index-sub-category', ['subCat' => $products->first()->subCategory])
  @elseif(preg_match('/categorias\//', Request::path()))
    <?php $productsTitle = "Productos en {$products->first()->subCategory->category->description}" ?>
    @include('product.addons.breadcrumbs-index-category', ['cat' => $products->first()->subCategory->category])
  @else
    <?php $productsTitle = 'Productos en orbiagro.com.ve' ?>
    @include('product.addons.breadcrumbs-index')
  @endif

  @unless(Request::input('page'))
    <div class="container">
      @unless($cats->isEmpty())
        <div class="row">
          <div class="col-xs-12">
            @include('category.addons.gallery-slick', ['title' => 'Categorias', 'cats' => $cats])
          </div>
        </div>
      @endunless
      @unless($subCats->isEmpty())
        <div class="row">
          <div class="col-xs-12">
            @include('category.addons.gallery-slick', ['title' => 'Rubros', 'cats' => $subCats])
          </div>
        </div>
      @endunless
    </div>

    {{-- TODO --}}
    {{-- categorias, sub-categorias (rubros), populares. --}}
  @endif
  <div class="container" style="margin-top: 15px;">
    <div class="row">
      <div class="col-xs-12">
        <h1>{{ $productsTitle }}</h1>
        @include('partials.products.paginated')
      </div>
    </div>
  </div>

  @include('visit.addons.relatedProducts')
@stop

@section('js')
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-cats').slick({
        arrows:false,
        autoplay: true,
        autoplaySpeed: 2000,
        centerMode: false,
        dots: true,
        infinite: false,
        lazyLoad: 'ondemand',
        speed: 300,
        slidesToShow: 7,
        variableWidth: true
      });
    });
  </script>
@stop
