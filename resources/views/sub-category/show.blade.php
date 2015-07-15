@extends('master')

@section('content')

  @if(Auth::user() and Auth::user()->isAdmin($subCat->id))
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('SubCategoriesController@edit', 'Editar', $subCat->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
      </div>
    </div>
  @endif

  @include('sub-category.addons.breadcrumbs-show')
  <div class="container" style="margin-top:15px;">
    @include('partials.products.paginated')
  </div>
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.sub-cat-paginated', ['title' => 'Rubros Relacionados'])
  @include('sub-category.addons.visited')
  @include('sub-category.addons.popular', ['title' => 'Rubros Populares'])

@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
@stop
