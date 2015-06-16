@unless($popularSubCats->isEmpty())
  <div class="container">
    <div class="row">
      <div class="col-xs-12" id="subCat-popular">
        <h1>Rubros Populares</h1>
      </div>
    </div>
    <div class="row">
      @include('partials.sub-category.gallerie-thumbnail', [
        'subCats' => $popularSubCats,
        'size' => 'col-sm-4',
      ])
    </div>
    @foreach($popularSubCats as $subcat)
      <div class="row related-subcategory" id="subCat-popular-{{ $subcat->id }}">
        <div class="col-xs-12">
          <h3>Algunos Productos en {{ $subcat->description }}</h3>
        </div>
        @foreach($subcat->products()->random()->take(6)->get() as $product)
          <div class="col-sm-2">
            <div class="thumbnail">
              <img
                src="{!! asset($product->images->first()->path) !!}"
                alt="{{ $product->images->first()->alt }}"
                class="img-responsive"/>
              <div class="caption">
                <h4>
                  {!! link_to_action('ProductsController@show', $product->title, $product->slug) !!}
                </h4>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
@endunless

@section('popular-subCats-js')
  <script type="text/javascript" src="{!! asset('js/galleries/popularSubCats-gallerie.js') !!}"></script>
@stop
