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

@stop

@section('js')
  {{-- galeria de productos visitados relacionados. --}}
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
