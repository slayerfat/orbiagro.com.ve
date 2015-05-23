@foreach($products as $product)
  <div class="{{$size}}">
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
