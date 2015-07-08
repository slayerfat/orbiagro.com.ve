@extends('master')

@section('title')
  - Index - {{$user->name}} - Productos
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      @include('user.addons.sidebar', ['active' => 'productsVisits'])
      <div class="col-sm-8">
        @include('partials.products.detailed', [
          'product' => $products->first(),
          'title' => 'El ultimo Producto que ha visitado'
        ])
      </div>
    </div>
  </div>
  @include('user.addons.productsVisits-paginated')
  @include('sub-category.addons.visited')
@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
@stop
