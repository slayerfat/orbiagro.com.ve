@unless($productsCollection->isEmpty())
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>{{ $title }}</h1>
      </div>
    </div>
    <div class="row">
      @include('partials.products.gallerie-thumbnail-products', [
        'products' => $productsCollection->random(),
        'size' => 'col-sm-2'
      ])
    </div>
  </div>
@endunless
