<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li class="active">
        <em>
          Categorias
        </em>
      </li>
      <li>
        {!! link_to_action('SubCategoriesController@index', 'Rubros') !!}
      </li>
      <li>
        {!! link_to_action('ProductsController@index', 'Productos') !!}
      </li>
    </ol>
  </div>
</div>
