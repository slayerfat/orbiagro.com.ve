@section('cat-description')
  <div class="form-group">
    {!! Form::label('description', 'Descripción:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('cat-info')
  <div class="form-group">
    {!! Form::label('info', 'Información detallada:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('info', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('cat-images')
  <div class="form-group">
    {!! Form::label('image', 'Imagen:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <input type="file" name="image" class="form-control" id="image" accept="image/*">
    </div>
  </div>
@stop
