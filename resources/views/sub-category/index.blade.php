@extends('master')

@section('title')
  - Index - Rubros
@stop

@section('content')
  @include('sub-category.addons.subcat-gallerie', ['title' => "Rubro Destacado"])

  <div class="container">
    <div class="row">
      @foreach($subCats as $cat)
      <div class="col-sm-12 well">
        <div class="row">
          <div class="col-xs-8">
            <h1>{!! link_to_action('SubCategoriesController@show', $cat->description, $cat->id) !!}</h1>
            <h2>
              <a href="{!! action('SubCategoriesController@show', $cat->id) !!}">
                <em>{{$cat->products->count()}} Productos</em>
              </a>
            </h2>
            <h3>{{$cat->info}}</h3>
          </div>
          <div class="col-xs-4">
            <a href="{!! action('SubCategoriesController@show', $cat->id) !!}">
              <img
              src="{{$cat->image->path}}"
              alt="{{$cat->image->alt}}"
              class="img-responsive"/>
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
@stop
