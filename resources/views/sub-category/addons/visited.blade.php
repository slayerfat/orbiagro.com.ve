@unless($visitedSubCats->isEmpty())
  <div class="container">
    <div class="row">
      <div class="col-xs-12" id="subCats-visits">
        <h1>Ultimos Rubros que ha visitado</h1>
      </div>
    </div>
    <div class="row">
      @include('partials.sub-category.visits-gallerie-thumbnail', [
        'subCats' => $visitedSubCats,
        'size' => 'col-sm-4',
      ])
    </div>
    @foreach($visitedSubCats as $subcat)
      <div class="row visited-subcategory" id="subCat-visits-{{ $subcat->id }}">
        <div class="col-xs-12">
          <h3>Algunos Productos en {{ $subcat->description }}</h3>
        </div>
        @foreach($subcat->products()->random()->take(6)->get() as $product)
          @unless($product->images->isEmpty())
            <div class="col-sm-2">
              <div class="thumbnail">
                <img
                  src="{!! asset($product->image->medium) !!}"
                  alt="{{ $product->image->alt }}"
                  class="img-responsive"/>
                <div class="caption">
                  <h4>
                    {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
                  </h4>
                </div>
              </div>
            </div>
          @endunless
        @endforeach
      </div>
    @endforeach
  </div>
@endunless

@section('visited-subCats-js')
  <script type="text/javascript" src="{!! asset('js/galleries/visitedSubCats-gallerie.js') !!}"></script>
@stop
