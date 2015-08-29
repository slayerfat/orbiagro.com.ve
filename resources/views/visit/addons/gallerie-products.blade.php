@foreach($visitedProducts->take(3)->all() as $product)
  <div class="col-sm-4">
    <div class="thumbnail">
      @unless(is_null($product->image))
        <img
          data-related-product="{{ $product->subCategory->id }}"
          src="{!! asset($product->image->medium) !!}"
          alt="{{ $product->image->alt }}"
          class="img-responsive"/>
      @endunless
      <div class="caption" data-related-product="{{ $product->subCategory->id }}">
        <h3>
          {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
