<div class="container">
  <div class="row">
    @if(isset($title))
      <div class="col-xs-12">
        <h1>{{$title}}</h1>
      </div>
    @endif
    @foreach($cats as $cat)
    <div class="col-sm-12 well">
      <div class="row">
        <div class="col-xs-8">
          <h1>{!! link_to_action('CategoriesController@show', $cat->description, $cat->id) !!}</h1>
          <h2>
            <a href="{!! action('CategoriesController@show', $cat->id) !!}">
              <em>{{$cat->sub_categories->count()}} Rubros</em>
            </a>
          </h2>
          <h3>{{$cat->info}}</h3>
        </div>
        <div class="col-xs-4">
          <a href="{!! action('CategoriesController@show', $cat->id) !!}">
            <img
            src="{!! asset($cat->image->path) !!}"
            alt="{{$cat->image->alt}}"
            class="img-responsive"/>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
