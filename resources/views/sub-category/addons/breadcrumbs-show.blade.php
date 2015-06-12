<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <ol class="breadcrumb no-margin">
        <li>
          {!! link_to_action('HomeController@index', 'Inicio') !!}
        </li>
        <li>
          {!! link_to_action('ProductsController@index', 'Productos') !!}
        </li>
        <li>
          {!! link_to_action('CategoriesController@show', $subCat->category->description, $subCat->category->id) !!}
        </li>
        <li class="active">
          <em>
            {!! $subCat->description !!}
          </em>
        </li>
      </ol>
    </div>
  </div>
</div>