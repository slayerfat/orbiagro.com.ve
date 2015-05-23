<h1>{{ $title }}</h1>
<div class="carrusel-cats">
  @foreach($cats as $cat)
    <div>
      <a href="{!! action($title == ('Rubros') ? 'SubCategoriesController@show' : 'CategoriesController@show', $cat->id) !!}">
        <img
        src="{!! asset($cat->image->path) !!}"
        alt="{{ $cat->image->alt }}"
        width="150px"
        height="150px"/>
      </a>
    </div>
  @endforeach
</div>
