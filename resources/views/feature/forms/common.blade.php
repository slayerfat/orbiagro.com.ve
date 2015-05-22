@section('feature-title')
  <div class="form-group">
    {!! Form::label('title', 'Titulo del Feature:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
    </div>
  </div>
@stop

@section('feature-description')
  <div class="form-group">
    {!! Form::label('description', 'Descripcion del Feature:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
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
