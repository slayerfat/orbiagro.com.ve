@foreach ($products as $product)
  <div class="row">
    <div class="col-xs-12">
      <h1>
        {{$title}}
      </h1>
    </div>
  </div>
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
          <div class="col-md-6 product-info">
            <p>
              Fecha de Eliminacion: {{$product->deleted_at}}
            </p>
            <p>
              {!! Date::parse($product->deleted_at)->diffForHumans() !!}.
            </p>
            <p>
              <i>
                Eliminado por:
                {!! Auth::user()->isOwnerOrAdmin($product->id) ? Auth::user()->name : 'orbiagro.com.ve'!!}
              </i>
            </p>
          </div>
          <div class="col-xs-3">
            {!! Form::open(['method' => 'POST', 'route' => ['products.restore', $product->id]]) !!}
            {!! Form::submit('Restaurar', ['class' => 'btn btn-info btn-block']) !!}
            {!! Form::close() !!}
            {!! Form::open(['method' => 'DELETE', 'route' => ['products.destroy.force', $product->id]]) !!}
            {!! Form::submit('Olvidar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach
