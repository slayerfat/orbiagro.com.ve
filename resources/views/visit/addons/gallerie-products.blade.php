@foreach($visitedProducts->take(3)->all() as $product)
  <div class="col-sm-4">
    <div class="thumbnail">
      <img
        data-related-product="{{ $product->sub_category->id }}"
        src="{!! asset($product->images->first()->path) !!}"
        alt="{{ $product->images->first()->alt }}"
        class="img-responsive"/>
      <div class="caption" data-related-product="{{ $product->sub_category->id }}">
        <h3>
          {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
