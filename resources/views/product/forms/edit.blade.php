@include('product.forms.common', [
  'price'    => $product->price,
  'quantity' => $product->quantity,
  'parish'   => $product->direction->parish_id,
  'map'      => $product->direction->map,
  'details'  => $product->direction->details,
])

@yield('product-title')

<div class="form-group">
  {!! Form::label('slug', 'slug:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-10">
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
  </div>
</div>

@yield('product-description')

@yield('product-price-quantity')

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
