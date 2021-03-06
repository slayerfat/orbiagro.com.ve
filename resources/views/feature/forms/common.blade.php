@section('feature-title')
  <div class="form-group">
    {!! Form::label('title', 'Titulo del Distintivo:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
    </div>
  </div>
@stop

@section('feature-description')
  <div class="form-group">
    {!! Form::label('description', 'Descripción del Distintivo:', ['class' => 'col-md-2 control-label']) !!}
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

@section('feature-file')
  <div class="form-group">
    {!! Form::label('file', 'Archivo Relacionado:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      <input type="file" name="file" class="form-control" id="file" accept=".pdf, .doc, .docx">
    </div>
  </div>
@stop
