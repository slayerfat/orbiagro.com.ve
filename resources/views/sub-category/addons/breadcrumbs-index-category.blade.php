<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_action('CategoriesController@show', $cat->description, $cat->slug) !!}
      </li>
      <li class="active">
        <em>
          Rubros
        </em>
      </li>
      <li>
        {!! link_to_action('ProductsController@indexByCategory', 'Productos', $cat->slug) !!}
      </li>
    </ol>
  </div>
</div>
