<div class="form-group">
  {!! Form::label('sku', 'SKU:', ['class' => 'col-md-3 control-label']) !!}
  <div class="col-md-9">
    {!! Form::text('sku', $product->sku, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('provider_id', 'Proveedor:', ['class' => 'col-md-3 control-label']) !!}
  <div class="col-md-9">
    {!! Form::select('provider_id', $providers, $providerId, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
