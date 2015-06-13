@extends('master')

@section('title')
  - Index - Categorias
@stop

@section('content')
  @include('category.addons.breadcrumbs-index')
  @include('sub-category.addons.subcat-gallerie', ['title' => "Rubro Destacado"])
  @include('category.addons.cat-paginated')
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.popular', [$popularSubCats, 'title' => 'Rubros Populares'])
@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
@stop
