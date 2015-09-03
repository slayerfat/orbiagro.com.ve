<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_route('home', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_route('cats.show', $subCat->category->description, $subCat->category->slug) !!}
      </li>
      <li class="active">
        <em>
          {!! $subCat->description !!}
        </em>
      </li>
      <li>
        {!! link_to_route('products.subcats.index', 'Productos', $subCat->slug) !!}
      </li>
    </ol>
  </div>
</div>
