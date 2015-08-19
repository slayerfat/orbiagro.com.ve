<h1>
  <a href="{!! action($title == ('Rubros') ? 'SubCategoriesController@index' : 'CategoriesController@index') !!}">
    {{ $title }}
  </a>
</h1>
<div class="carrusel-cats">
  @foreach($cats as $cat)
    <div>
      <a href="{!! action($title == ('Rubros') ? 'SubCategoriesController@show' : 'CategoriesController@show', $cat->slug) !!}">
        @if($cat->image)
          <img
          data-lazy="{!! asset($cat->image->small) !!}"
          alt="{{ $cat->image->alt }}"/>
        @endif
      </a>
    </div>
  @endforeach
</div>
