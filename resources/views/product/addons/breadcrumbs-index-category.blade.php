<div class="container">
  <div class="row">
    <ol class="breadcrumb no-margin">
      <li>
        {!! link_to_route('home', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_route('cats.show', $cat->description, $cat->slug) !!}
      </li>
      <li>
        {!! link_to_route('cats.subCats.index', 'Rubros', $cat->slug) !!}
      </li>
      <li class="active">
        Productos
      </li>
    </ol>
  </div>
</div>
