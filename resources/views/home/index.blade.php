@extends('master')

@section('content')
  <div class="container">
    <div class="carrusel-main">
      <div><img src="http://placehold.it/500/50" alt="" /></div>
      <div><img src="http://placehold.it/500/500" alt="" /></div>
      <div><img src="http://placehold.it/500/200" alt="" /></div>
    </div>
  </div>

  @include('partials.orbiagro-info')
  @include('promotion.addons.4-4-4-gallerie')
  @include('sub-category.addons.relatedProducts', [$sub_category, 'title' => 'Productos en '.$sub_category->description])
  @include('visit.addons.relatedProducts')
@stop

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-main').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true
      });
    });
  </script>

  {{-- galeria de productos visitados relacionados. --}}
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
