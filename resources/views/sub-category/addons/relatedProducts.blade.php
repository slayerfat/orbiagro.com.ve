@unless($subCategory->products->isEmpty())
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>{!!$title!!}</h1>
      </div>
    </div>
    <div class="row">
      @include('partials.products.gallerie-thumbnail-products', [
        'products' => $subCategory->products->take(3),
        'size' => 'col-sm-4'
      ])
    </div>
  </div>
@endunless
