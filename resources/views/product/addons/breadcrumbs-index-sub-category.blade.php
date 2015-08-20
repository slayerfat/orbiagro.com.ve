<div class="container">
  <div class="row">
    <ol class="breadcrumb no-margin">
      <li>
        {!! link_to_action('HomeController@index', 'Inicio') !!}
      </li>
      <li>
        {!! link_to_action('CategoriesController@show', $subCat->category->description, $subCat->category->slug) !!}
      </li>
      <li>
        {!! link_to_action('SubCategoriesController@show', $subCat->description, $subCat->slug) !!}
      </li>
      <li class="active">
        Productos
      </li>
    </ol>
  </div>
</div>
