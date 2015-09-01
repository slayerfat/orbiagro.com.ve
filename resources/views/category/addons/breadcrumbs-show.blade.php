<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_route('home', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_route('cats.index', 'Categorias') !!}
      </li>
      <li class="active">
        <em>
          {{$cat->description}}
        </em>
      </li>
      <li>
        {!! link_to_route('cats.subCats.index', 'Rubros', $cat->slug) !!}
      </li>
      <li>
        {!! link_to_route('products.cats.index', 'Productos', $cat->slug) !!}
      </li>
    </ol>
  </div>
</div>
