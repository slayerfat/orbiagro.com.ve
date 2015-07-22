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
                src="{!! asset($product->images()->first()->path) !!}"
                alt="{{ $product->images()->first()->alt }}"
                width="128" height="128">
            @endunless
          </a>
        </div>
        <div class="media-body product-details-container">
          <a href="{!! action('ProductsController@show', $product->slug) !!}">
            <h4 class="media-heading product-title">{{ $product->title }}</h4>
          </a>
          <div class="col-md-3 product-price">
            {{ $product->price_bs() }}
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
            {!! Form::open(['method' => 'POST', 'action' => ['ProductsController@restore', $product->id]]) !!}
            {!! Form::submit('Restaurar', ['class' => 'btn btn-info btn-block']) !!}
            {!! Form::close() !!}
            {!! Form::open(['method' => 'DELETE', 'action' => ['ProductsController@forceDestroy', $product->id]]) !!}
            {!! Form::submit('Olvidar', ['class' => 'btn btn-danger btn-block', 'onclick' => 'deleteResourceConfirm()']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach

{{-- @foreach($products as $product)
  <div class="deleted-product">
    <h1>
      {{$title}}
    </h1>
    <h2>
      {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
    </h2>
    <div class="col-xs-6">
      @unless($product->images->isEmpty())
        <img
          src="{!! asset($product->images->first()->path) !!}"
          alt="{{ $product->images->first()->alt }}"
          class="img-responsive"/>
      @endunless
    </div>
    <div class="col-xs-6">
      <p>
        Fecha de eliminacion:
      </p>
    </div>
  </div>
@endforeach --}}
