@extends('master')

@section('title')
  - Index - {{$user->name}} - Productos
@stop

@section('content')
  <div class="container-fluid">
    <div class="row">
      @include('user.addons.sidebar', ['active' => 'products'])
      <div class="col-sm-8">
        @include('partials.products.detailed', [
          'product' => $user->products()->latest()->first(),
          'title' => 'Ultimo Producto creado'
        ])
        @if(Auth::user() and Auth::user()->isOwnerOrAdmin($user->id))
          <div class="row">
            <div class="col-xs-12">
              @if($user->latestDeletedProducts())
                @include('partials.products.user-deleted', [
                  'products' => $user->latestDeletedProducts(),
                  'title'    => 'Ultimos Productos eliminados',
                  ])
              @endif
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
  @include('user.addons.products-paginated')
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.visited')
@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
