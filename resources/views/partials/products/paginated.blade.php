@if (isset($products))
  @unless($products->isEmpty())
    @foreach ($products as $product)
      <div class="row">
        <div class="col-xs-12">
          <div class="media product-media">
            <div class="media-left product-image-container">
              <a href="{!! action('ProductsController@show', $product->slug) !!}">
                @unless($product->images->isEmpty())
                  <img
                    class="media-object product-image"
                    src="{!! asset($product->image->small) !!}"
                    alt="{{ $product->image->alt }}">
                @endunless
              </a>
            </div>
            <div class="media-body product-details-container">
              <a href="{!! action('ProductsController@show', $product->slug) !!}">
                <h4 class="media-heading product-title">{{ $product->title }}</h4>
              </a>
              <div class="col-md-3 product-price">
                {{ $product->priceBs() }}
              </div>
              <div class="col-md-9 product-features">
                @if($product->features)
                  @foreach($product->features as $features)
                    <li>{{ $features->title }}</li>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    {!! $products->render() !!}
  @else
    <div class="row">
      <div class="col-xs-12">
        <h2>Oh, Parece ser que no hay Productos!</h2>
        @if(Auth::guest())
          <h3>
            <a href="/auth/login">Entra y Crea un nuevo Producto</a>
          </h3>
          <h3>
            <a href="/auth/register">O Registrate para Crear un nuevo Producto</a>
          </h3>
        @else
          <h3>
            {!! link_to_route('products.create', 'Crea un nuevo Producto') !!}
          </h3>
        @endif
      </div>
    </div>
  @endunless
@endif
