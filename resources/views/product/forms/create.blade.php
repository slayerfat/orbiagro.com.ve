@include('product.forms.common', [
  'price'    => null,
  'quantity' => null,
  'parish'   => null,
  'map'      => null,
  'details'  => null,
])

@yield('product-title')
@yield('product-description')
@yield('product-price-quantity')
@yield('product-images')
@yield('product-direction')
@yield('product-map')
@yield('product-details')
@yield('product-makers')
@yield('product-categories')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
