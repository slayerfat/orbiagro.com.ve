<div class="container">
  <div class="row">
    <ol class="breadcrumb no-margin">
      <li>
        {!! link_to_route('home', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_route('cats.show', $subCat->category->description, $subCat->category->slug) !!}
      </li>
      <li>
        {!! link_to_route('subCats.show', $subCat->description, $subCat->slug) !!}
      </li>
      <li class="active">
        Productos
      </li>
    </ol>
  </div>
</div>
