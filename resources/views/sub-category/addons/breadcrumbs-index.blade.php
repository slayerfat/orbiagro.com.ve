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
          Rubros
        </em>
      </li>
      <li>
        {!! link_to_action('ProductsController@index', 'Productos') !!}
      </li>
    </ol>
  </div>
</div>
