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
  @include('category.addons.cat-list')
  @include('promotion.addons.4-4-4-gallerie')
  @if($sub_category)
    @include('sub-category.addons.relatedProducts', [$sub_category, 'title' => link_to_action('SubCategoriesController@show', $sub_category->description.' y sus productos en Orbiagro', $sub_category->slug)])
  @endif
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.visited')
  @include('sub-category.addons.popular', ['title' => 'Visite los Rubros Populares'])
@stop

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-main').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true
      });
    });
  </script>

  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
@stop
