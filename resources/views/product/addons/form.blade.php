<div class="form-group">
  {!! Form::label('title', 'Titulo:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-10">
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('slug', 'slug:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-10">
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('description', 'Descripcion:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-10">
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('price', 'Precio:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-4">
    {!! Form::input('number', 'price', $product->price, ['class' => 'form-control']) !!}
  </div>
  {!! Form::label('quantity', 'Cantidad:', ['class' => 'col-md-2 control-label']) !!}
  <div class="col-md-4">
    {!! Form::input('number', 'quantity', $product->quantity, ['class' => 'form-control']) !!}
  </div>
</div>

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
      <option value="{!! $product->direction->first()->parish_id !!}"></option>
    </select>
  </div>
</div>

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
