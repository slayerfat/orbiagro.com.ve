@foreach($products as $product)
  <div class="{{$size}}">
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
