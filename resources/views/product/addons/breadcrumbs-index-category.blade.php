<div class="container">
  <div class="row">
    <ol class="breadcrumb no-margin">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_action('CategoriesController@show', $cat->description, $cat->slug) !!}
      </li>
      <li>
        {!! link_to_action('SubCategoriesController@indexByCategory', 'Rubros', $cat->slug) !!}
      </li>
      <li class="active">
        Productos
      </li>
    </ol>
  </div>
</div>
