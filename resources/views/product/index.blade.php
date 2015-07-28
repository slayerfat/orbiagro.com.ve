@extends('master')

@section('content')

  @include('product.addons.breadcrumbs-index')

  @unless(Request::input('page'))
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          @include('category.addons.gallery-slick', ['title' => 'Categorias', 'cats' => $cats])
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          @include('category.addons.gallery-slick', ['title' => 'Rubros', 'cats' => $subCats])
        </div>
      </div>
    </div>

    {{-- TODO --}}
    {{-- categorias, sub-categorias (rubros), populares. --}}
  @endif
  <div class="container" style="margin-top: 15px;">
    <div class="row">
      <div class="col-xs-12">
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
