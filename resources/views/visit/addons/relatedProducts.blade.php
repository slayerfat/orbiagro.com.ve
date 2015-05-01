<div class="container">
  @unless($visitedProducts->isEmpty())
    <div class="row">
      <div class="col-xs-12">
        <h1>Ultimos Productos que ha visitado</h1>
      </div>
    </div>
    <div class="row">
      @include('visit.addons.gallerie-products')
    </div>
    @foreach($visitedProducts as $visited)
      <div class="row related-subcategory-product" id="{{ $visited->sub_category->id }}">
        <?php $products = App\SubCategory::find($visited->sub_category->id)->products->take(6); ?>
        <div class="col-xs-12">
          <h3>Recomendaciones por visitar la Categoria {{ $visited->sub_category->description }}</h3>
        </div>
        @foreach($products as $product)
          <div class="col-sm-2">
            <div class="thumbnail">
              <img
                src="{!! asset($product->images->first()->path) !!}"
                alt="{{ $product->images->first()->alt }}"
                class="img-responsive"/>
              <div class="caption">
                <h4>
                  {!! link_to_action('ProductsController@show', $product->title, $product->id) !!}
                </h4>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  @endunless
</div>
