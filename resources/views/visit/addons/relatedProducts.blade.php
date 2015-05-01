<div class="container">
  @if($visitedProducts)
    <div class="row">
      <div class="col-xs-12">
        <h1>Ultimos Productos que ha visitado</h1>
      </div>
    </div>
    <div class="row">
      @include('visit.addons.gallerie-products')
    </div>
    @foreach($visitedProducts as $visited)
      <div class="row">
        <?php $products = App\SubCategory::find($visited->sub_category->id)->products; ?>
        @foreach($products as $product)
          <div class="col-sm-4">
            <div class="thumbnail">
              <img
                src="{!! asset($product->images->first()->path) !!}"
                alt="{{ $product->images->first()->alt }}"
                class="img-responsive"/>
              <div class="caption">
                <h3>
                  {!! link_to_action('ProductsController@show', $product->title, $product->id) !!}
                </h3>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  @endif
</div>
