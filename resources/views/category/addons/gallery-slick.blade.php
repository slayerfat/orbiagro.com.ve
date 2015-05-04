<h1>{{ $title }}</h1>
<div class="carrusel-cats">
  @foreach($cats as $cat)
    <div>
      <img src="{!! asset($cat->image->path) !!}" alt="{{ $cat->name }}" width="150px" height="150px"/>
    </div>
  @endforeach
</div>
