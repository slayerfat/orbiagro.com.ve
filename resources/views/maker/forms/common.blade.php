@section('name')
  <div class="form-group">
    {!! Form::label('name', 'Nombre:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('domain')
  <div class="form-group">
    {!! Form::label('domain', 'Dominio:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('domain', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('url')
  <div class="form-group">
    {!! Form::label('url', 'Dirección Url:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('url', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('image')
  <div class="form-group">
    {!! Form::label('image', 'Imagen:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <input type="file" name="image" class="form-control" id="image" accept="image/*">
    </div>
  </div>
@stop
