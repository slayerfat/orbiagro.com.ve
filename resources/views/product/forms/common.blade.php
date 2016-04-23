@section('product-title')
  <div class="form-group">
    {!! Form::label('title', 'Titulo:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('product-description')
  <div class="form-group">
    {!! Form::label('description', 'Descripción:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'product-description']) !!}
    </div>
  </div>
@stop

@section('product-price-quantity')
  <div class="form-group">
    {!! Form::label('price', 'Precio:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::input('number', 'price', $price, ['class' => 'form-control', 'placeholder' => 'Vacío significa precio a convenir']) !!}
    </div>
    {!! Form::label('quantity', 'Cantidad:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::input('number', 'quantity', $quantity, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('product-direction')
  <div class="form-group">
    {!! Form::label('state_id', 'Estado:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <select name="state_id" id="state_id" class="form-control">
      </select>
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('town_id', 'Municipio:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <select name="town_id" id="town_id" class="form-control">
      </select>
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('parish_id', 'Parroquia:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <select name="parish_id" id="parish_id" class="form-control">
        <option value="{!! $parish !!}"></option>
      </select>
    </div>
  </div>
@stop

@section('product-map')
  <div class="form-group">
    <div id="map-canvas" class="col-xs-12 embed-responsive embed-responsive-16by9"></div>
    @if($map)
      <div class="hidden">
        {!! Form::text('longitude', $map->longitude) !!}
        {!! Form::text('latitude', $map->latitude) !!}
        {!! Form::text('zoom', $map->zoom) !!}
      </div>
    @else
      <div class="hidden">
        {!! Form::text('longitude', 0) !!}
        {!! Form::text('latitude', 0) !!}
        {!! Form::text('zoom', 0) !!}
      </div>
    @endif
  </div>
@stop

@section('product-details')
<div class="form-group">
  {!! Form::label('details', 'Direccion Exacta:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-10">
    {!! Form::text('details', $details, ['class' => 'form-control']) !!}
  </div>
</div>
@stop

@section('product-makers')
  <div class="form-group">
    {!! Form::label('maker_id', 'Fabricante:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::select('maker_id', $makers, null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('product-categories')
  <div class="form-group">
    {!! Form::label('sub_category_id', 'Categoria:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::select('sub_category_id', $cats, null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('product-images')
  <div class="form-group">
    {!! Form::label('images', 'Imagenes:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <input type="file" name="images[]" multiple class="form-control" id="images" accept="image/*">
    </div>
  </div>
@stop
