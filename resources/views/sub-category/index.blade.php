@extends('master')

@section('title')
  - Index - Rubros
@stop

@section('content')
  @include('sub-category.addons.subcat-gallerie', ['title' => 'Rubro Destacado'])
@stop
