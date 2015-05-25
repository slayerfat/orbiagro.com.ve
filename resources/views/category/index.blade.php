@extends('master')

@section('title')
  - Index - Categorias
@stop

@section('content')
  @include('category.addons.breadcrumbs-index')
  @include('sub-category.addons.subcat-gallerie', ['title' => "Rubro Destacado"])
  @include('category.addons.cat-paginated')
  @include('visit.addons.relatedProducts')
@stop

@section('js')
  {{-- galeria de productos visitados relacionados. --}}
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
