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
              <h1>
                Ultimos Productos eliminados
              </h1>
              @if($user->latestDeletedProducts())
                @foreach($user->latestDeletedProducts() as $product)
                  <h2>
                    {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
                  </h2>
                @endforeach
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
@stop
