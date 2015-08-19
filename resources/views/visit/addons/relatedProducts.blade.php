@unless($visitedProducts->isEmpty())
  <div class="container">
    <div class="row">
      <div class="col-xs-12" id="products-visits">
        <h1>Ultimos Productos que ha visitado</h1>
      </div>
    </div>
    <div class="row">
      @include('visit.addons.gallerie-products')
    </div>
    @foreach($visitedProducts as $visited)
      <div class="row related-subcategory-product" id="products-visits-{{ $visited->subCategory->id }}">
        <?php $products = App\SubCategory::find($visited->subCategory->id)->products->take(6); ?>
        <div class="col-xs-12">
          <h3>Recomendaciones por visitar la Categoria {{ $visited->subCategory->description }}</h3>
        </div>
        @foreach($products as $product)
          <div class="col-sm-2">
            <div class="thumbnail">
              @unless($product->images->isEmpty())
                <img
                  src="{!! asset($product->image->medium) !!}"
                  alt="{{ $product->image->alt }}"
                  class="img-responsive"/>
              @endunless
              <div class="caption">
                <h4>
                  {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
                </h4>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
@endunless

@section('relatedProducts-js')
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
