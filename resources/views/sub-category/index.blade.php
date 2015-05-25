@extends('master')

@section('title')
  - Index - Rubros
@stop

@section('content')
  @include('sub-category.addons.breadcrumbs-index')
  @include('sub-category.addons.subcat-gallerie', ['title' => "Rubro Destacado"])
  @include('sub-category.addons.sub-cat-paginated')
  @include('visit.addons.relatedProducts')
@stop

@section('js')
  {{-- galeria de productos visitados relacionados. --}}
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
