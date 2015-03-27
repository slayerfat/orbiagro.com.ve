<div class="container">
  <ol class="breadcrumb no-margin">
    <li>
      {!! link_to_action('HomeController@index', 'Inicio') !!}
    </li>
    <li>
      {!! link_to_action('ProductsController@index', 'Productos') !!}
    </li>
    <li class="active">
      <em>
        {!! $product->title !!}
      </em>
    </li>
  </ol>
</div>
