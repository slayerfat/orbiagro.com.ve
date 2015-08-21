@extends('master')

@section('content')
  @include('partials.carrusel-main')

  @include('partials.orbiagro-info')
  @include('category.addons.cat-list')
  @include('promotion.addons.4-4-4-gallerie')

  @if($subCategory)
    @include('sub-category.addons.relatedProducts', [$subCategory, 'title' => link_to_action('SubCategoriesController@show', $subCategory->description.' y sus productos en Orbiagro', $subCategory->slug)])
  @endif

  @include('visit.addons.relatedProducts')
  {{-- ads --}}
  @include('partials.ads.full-12')
  @include('sub-category.addons.visited')
  @include('sub-category.addons.popular', ['title' => 'Visite los Rubros Populares'])
@stop

@section('js')
  {{-- vendor --}}
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>

  {{-- javascript para productos, rubros y otros. --}}
  @yield('carrusel-main-js')
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
@stop
