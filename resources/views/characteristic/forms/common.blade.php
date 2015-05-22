@section('char-height')
  <div class="form-group">
    {!! Form::label('height', 'Altura:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('height', null, ['class' => 'form-control', 'id' => 'height']) !!}
    </div>
  </div>
@stop

@section('char-width')
  <div class="form-group">
    {!! Form::label('width', 'Ancho:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('width', null, ['class' => 'form-control', 'id' => 'width']) !!}
    </div>
  </div>
@stop

@section('char-depth')
  <div class="form-group">
    {!! Form::label('depth', 'Profundidad:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('depth', null, ['class' => 'form-control', 'id' => 'depth']) !!}
    </div>
  </div>
@stop

@section('char-weight')
  <div class="form-group">
    {!! Form::label('weight', 'Peso:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('weight', null, ['class' => 'form-control', 'id' => 'weight']) !!}
    </div>
  </div>
@stop

@section('char-units')
  <div class="form-group">
    {!! Form::label('units', 'Unidades por paquete (si aplica):', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-8">
      {!! Form::text('units', null, ['class' => 'form-control', 'id' => 'units']) !!}
    </div>
  </div>
@stop
