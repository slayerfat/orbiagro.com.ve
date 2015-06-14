<div class="container">
  <div class="row">
    <ol class="breadcrumb">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_action('ProductsController@index', 'Productos') !!}
      </li>
      <li class="active">
        <em>
          {{$cat->description}}
        </em>
      </li>
    </ol>
  </div>
</div>
