@extends('master')

@section('content')

  @if(Auth::user() and Auth::user()->isAdmin())
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          {!! link_to_action('CategoriesController@edit', 'Editar', $cat->id, ['class' => 'btn btn-default btn-block']) !!}
        </div>
        <div class="col-xs-2">
          {!! Form::open(['method' => 'DELETE', 'action' => ['CategoriesController@destroy', $cat->id]]) !!}
          {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
          {!! Form::close() !!}
        </div>
        @if($cat->image)
          <div class="col-xs-2">
            <span>
              <a href="{{ action('ImagesController@edit', $cat->image->id) }}">
                <button
                  type="button"
                  name="image-edit"
                  class="btn btn-default">Editar Imagen</button>
              </a>
            </span>
          </div>
        @endif
      </div>
    </div>
  @endif

  @include('category.addons.breadcrumbs-show')
  @include('sub-category.addons.sub-cat-paginated')
  @include('visit.addons.relatedProducts')
  @include('sub-category.addons.visited')
  @include('sub-category.addons.popular', ['title' => 'Rubros Populares'])

@stop

@section('js')
  {{-- javascript para productos, rubros y otros. --}}
  @yield('relatedProducts-js')
  @yield('popular-subCats-js')
  @yield('visited-subCats-js')
  {{-- js de eliminar recurso --}}
  <script src="{!! asset('js/show/deleteResourceConfirm.js') !!}"></script>
@stop
