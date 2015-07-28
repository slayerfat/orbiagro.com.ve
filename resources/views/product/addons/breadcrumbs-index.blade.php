<div class="container">
  <div class="row">
    <ol class="breadcrumb no-margin">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li class="active">
        {!! link_to_action('CategoriesController@index', 'Categorias') !!}
      </li>
      <li>
        {!! link_to_action('SubCategoriesController@index', 'Rubros') !!}
      </li>
      <li>
        <em>
          Productos
        </em>
      </li>
    </ol>
  </div>
</div>
