<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_action('CategoriesController@index', 'Categorias') !!}
      </li>
      <li class="active">
        <em>
          {{$cat->description}}
        </em>
      </li>
      <li>
        {!! link_to_action('SubCategoriesController@indexByCategory', 'Rubros', $cat->slug) !!}
      </li>
      <li>
        {!! link_to_action('ProductsController@indexByCategory', 'Productos', $cat->slug) !!}
      </li>
    </ol>
  </div>
</div>
