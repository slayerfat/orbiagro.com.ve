<div class="container">
  <div class="row">
    @if(isset($title))
      <div class="col-xs-12">
        <h1>{{$title}}</h1>
      </div>
    @endif
    @foreach($subCats as $cat)
      <div class="col-sm-12 well">
        <div class="row">
          <div class="col-xs-8">
            <h1>{!! link_to_action('SubCategoriesController@show', $cat->description, $cat->slug) !!}</h1>
            <h2>
              <a href="{!! action('SubCategoriesController@show', $cat->slug) !!}">
                <em>{{$cat->products->count()}} Productos</em>
              </a>
            </h2>
            <h3>{{$cat->info}}</h3>
          </div>
          <div class="col-xs-4">
            <a href="{!! action('SubCategoriesController@show', $cat->slug) !!}">
              @if($cat->image)
                <img
                src="{!! asset($cat->image->medium) !!}"
                alt="{{$cat->image->alt}}"
                class="img-responsive"/>
              @endif
            </a>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <h3>Algunos Productos existentes en {{$cat->description}}</h3>
        <div class="row">
          @include('partials.products.gallerie-thumbnail-products', [
            'products' => $cat->products()->random()->take(8)->get(),
            'size' => 'col-sm-3'
          ])
        </div>
      </div>
    @endforeach
  </div>
</div>
