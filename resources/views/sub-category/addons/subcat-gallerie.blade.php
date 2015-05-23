<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1>{{ $title }}</h1>
    </div>
  </div>
  <div class="row">
    @include('sub-category.addons.gallerie-thumbnail-products', [
      'products' => $productsCollection->random(3),
      'size' => 'col-sm-4'
    ])
  </div>
</div>
