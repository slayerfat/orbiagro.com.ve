<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <ol class="breadcrumb no-margin">
        <li>
          {!! link_to_action('HomeController@index', 'Inicio') !!}
        </li>
        <li>
          {!! link_to_action('CategoriesController@show', $product->subCategory->category->description, $product->subCategory->category->slug) !!}
        </li>
        <li>
          {!! link_to_action('SubCategoriesController@show', $product->subCategory->description, $product->subCategory->slug) !!}
        </li>
        <li class="active">
          <em>
            {!! $product->title !!}
          </em>
        </li>
      </ol>
    </div>
  </div>
</div>
