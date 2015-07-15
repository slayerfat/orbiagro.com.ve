@extends('master')

@section('content')
  @include('sub-category.addons.breadcrumbs-index')
  @include('sub-category.addons.subcat-gallerie', ['title' => "Rubro Destacado"])
  @include('sub-category.addons.sub-cat-paginated')
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.visited')
  @include('sub-category.addons.popular', ['title' => 'Rubros Populares'])
@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
@stop
