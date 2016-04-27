@foreach($visitedProducts->take(3)->all() as $product)
  <div class="col-sm-4">
    <div class="thumbnail">
      @if($product->image)
        <img
          data-related-product="{{ $product->subCategory->id }}"
          src="{!! asset($product->image->medium) !!}"
          alt="{{ $product->image->alt }}"
          class="img-responsive"/>
      @else
        <img
          src="{{ asset('sin_imagen.gif') }}"
          alt="{{ $product->title }}"
          class="img-responsive"/>
      @endif
      <div class="caption" data-related-product="{{ $product->subCategory->id }}">
        <h3>
          {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
        </h3>
      </div>
    </div>
  </div>
@endforeach
