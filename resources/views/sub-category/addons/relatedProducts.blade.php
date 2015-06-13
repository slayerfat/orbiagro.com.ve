<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1>{{ $title }}</h1>
    </div>
  </div>
  <div class="row">
    @include('partials.products.gallerie-thumbnail-products', [
      'products' => $sub_category->products->take(3),
      'size' => 'col-sm-4'
    ])
  </div>
</div>

@section('relatedProducts-js')
  <script type="text/javascript" src="{!! asset('js/galleries/relatedVisits.js') !!}"></script>
@stop
