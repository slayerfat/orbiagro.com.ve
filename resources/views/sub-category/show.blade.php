@extends('master')

@section('content')

  @if(Auth::user() and Auth::user()->isAdmin($subCat->id))
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_route('subCats.edit', 'Editar', $subCat->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
        <div class="col-xs-2">
          {!! Form::open(['method' => 'DELETE', 'route' => ['subCats.destroy', $subCat->id]]) !!}
          {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
          {!! Form::close() !!}
        </div>
        @if($subCat->image)
          @include('partials.images.image-admin-buttons', ['image' => $subCat->image])
        @endif
      </div>
    </div>
  @endif

  @include('sub-category.addons.breadcrumbs-show')
  <div class="container" style="margin-top:15px;">
    <div class="row">
      <div class="col-xs-12">
        <h1>
          Productos dentro de {{$subCat->description}}
        </h1>
      </div>
    </div>
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
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
