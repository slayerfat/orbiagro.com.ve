<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <ol class="breadcrumb no-margin">
        <li>
          {!! link_to_route('home', 'Inicio') !!}
        </li>
        <li>
          {!! link_to_route('cats.show', $product->subCategory->category->description, $product->subCategory->category->slug) !!}
        </li>
        <li>
          {!! link_to_route('subCats.show', $product->subCategory->description, $product->subCategory->slug) !!}
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
