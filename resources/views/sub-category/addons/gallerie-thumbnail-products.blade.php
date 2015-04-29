@foreach($sub_category->products->take(3) as $product)
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
