@extends('master')

@section('title')
  - Index - {{$user->name}} - Productos
@stop

@section('content')
  @include('user.addons.products-paginated', ['title' => "Productos de {$user->name}"])
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.visited')
@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
@stop
