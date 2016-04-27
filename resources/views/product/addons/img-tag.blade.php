@if(!$product->images->isEmpty())
  <img
    src="{!! asset($product->image->medium) !!}"
    alt="{{ $product->image->alt }}"
    class="img-responsive"/>
@else
  <img
    src="{!! asset('sin_imagen.gif') !!}"
    alt="{{ $product->title }}"
    class="img-responsive"/>
@endif