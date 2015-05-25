@extends('master')

@section('title')
  - Index - Rubros
@stop

@section('content')
  @include('sub-category.addons.breadcrumbs-index')
  @include('sub-category.addons.subcat-gallerie', ['title' => "Rubro Destacado"])
  @include('sub-category.addons.sub-cat-paginated')
@stop
