<div class="container">
    @unless($productsBag->isEmpty())
      <div class="row">
        <div class="col-xs-12">
          <h1>
            {!! link_to_action('UsersController@show', "Productos relacionados con {$user->name}", $user->name) !!}
          </h1>
        </div>
      </div>
      @foreach($productsBag as $products)
        {{-- TODO: mejorar --}}
        <?php $products = collect($products) ?>
        <div class="row">
          <div class="col-sm-12">
            <h1>{!! link_to_action('SubCategoriesController@show', $products[0]->subCategory->description, $products[0]->subCategory->slug) !!}</h1>
            <h2><em>{!! sizeof($products) !!} Productos</em></h2>
          </div>
        </div>
        @foreach($products->chunk(4) as $chunk)
          <div class="row">
            @include('partials.products.gallerie-thumbnail-products', [
              'products' => $chunk,
              'size' => 'col-sm-3'
            ])
          </div>
        @endforeach
      @endforeach
    @else
      <div class="row">
        <div class="col-xs-12">
          <h1>
            Parece ser que este usuario no posee productos!
          </h1>
        </div>
      </div>
    @endunless
</div>
