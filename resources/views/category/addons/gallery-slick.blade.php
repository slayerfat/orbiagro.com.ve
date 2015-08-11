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
          src="{!! asset($cat->image->path) !!}"
          alt="{{ $cat->image->alt }}"
          width="150px"
          height="150px"/>
        @endif
      </a>
    </div>
  @endforeach
</div>
