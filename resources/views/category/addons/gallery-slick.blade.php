<h1>
  <a href="{!! route($title == ('Rubros') ? 'subCats.index' : 'cats.index') !!}">
    {{ $title }}
  </a>
</h1>
<div class="carrusel-cats">
  @foreach($cats as $cat)
    <div>
      <a href="{!! route($title == ('Rubros') ? 'subCats.show' : 'cats.show', $cat->slug) !!}">
        @if($cat->image)
          <img
          data-lazy="{!! asset($cat->image->small) !!}"
          alt="{{ $cat->image->alt }}"/>
        @endif
      </a>
    </div>
  @endforeach
</div>
