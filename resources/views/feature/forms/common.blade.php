@section('feature-title')
  <div class="form-group">
    {!! Form::label('feature_title', 'Titulo del Feature:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('feature_title', null, ['class' => 'form-control', 'id' => 'feature_title']) !!}
    </div>
  </div>
@stop

@section('feature-description')
  <div class="form-group">
    {!! Form::label('feature_description', 'Descripcion del Feature:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('feature_description', null, ['class' => 'form-control', 'id' => 'feature_description']) !!}
    </div>
  </div>
@stop

@section('feature-image')
  <div class="form-group">
    {!! Form::label('image', 'Imagen:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <input type="file" name="image" class="form-control" id="image" accept="image/*">
    </div>
  </div>
@stop
