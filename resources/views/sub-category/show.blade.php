@extends('master')

@section('title')
  - Rubro - {{ $subCat->description }}
@stop

@section('content')

  @if(Auth::user() and Auth::user()->isOwnerOrAdmin($subCat->id))
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('SubCategoriesController@edit', 'Editar', $subCat->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
      </div>
    </div>
  @endif

  @include('sub-category.addons.breadcrumbs-show')
  @include('partials.products.paginated')
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.sub-cat-paginated', ['title' => 'Rubros Relacionados'])

@stop

@section('js')
  {{-- galeria de productos visitados relacionados. --}}
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
