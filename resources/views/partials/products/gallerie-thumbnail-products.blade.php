@if(isset($products))
  @foreach($products as $product)
    <div class="{!!isset($size) ? $size : 'col-xs-4'!!}">
      <div class="thumbnail">
        @include('product.addons.img-tag')
        <div class="caption">
          <h4>
            {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
          </h4>
        </div>
      </div>
    </div>
  @endforeach
@endif
