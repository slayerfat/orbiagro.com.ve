<div class="container">
    @unless($user->visits->isEmpty())
      @foreach($products->chunk(4) as $chunk)
        <div class="row">
          @include('partials.products.gallerie-thumbnail-products', [
            'products' => $chunk,
            'size' => 'col-sm-3'
          ])
        </div>
      @endforeach
    @else
      <div class="row">
        <div class="col-xs-12">
          <h1>
            Parece ser que este usuario no ha visitado ningun
            {!! link_to_route('products.index', 'Producto') !!}!
          </h1>
        </div>
      </div>
    @endunless
</div>
