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
        @include('category.addons.gallery-slick', ['title' => 'Rubros', 'cats' => $subCats])
      </div>
    </div>

    {{-- TODO --}}
    {{-- categorias, sub-categorias (rubros), populares. --}}
  @endif

  @include('partials.products.paginated')

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
