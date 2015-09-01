<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_route('home', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_route('cats.show', $cat->description, $cat->slug) !!}
      </li>
      <li class="active">
        <em>
          Rubros
        </em>
      </li>
      <li>
        {!! link_to_route('products.cats.index', 'Productos', $cat->slug) !!}
      </li>
    </ol>
  </div>
</div>
