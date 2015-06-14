@extends('master')

@section('title')
  - Categoria - {{ $cat->description }}
@stop

@section('content')

  @if(Auth::user() and Auth::user()->isOwnerOrAdmin($cat->id))
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('CategoriesController@edit', 'Editar', $cat->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
      </div>
    </div>
  @endif

  @include('category.addons.breadcrumbs-show')
  @include('sub-category.addons.sub-cat-paginated')
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.popular', ['title' => 'Rubros Populares'])

@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
@stop
