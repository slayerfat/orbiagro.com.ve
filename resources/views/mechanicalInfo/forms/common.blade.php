@section('mech-motor-serial')
  <div class="form-group">
    {!! Form::label('motor', 'Motor:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('motor', null, ['class' => 'form-control', 'id' => 'motor']) !!}
    </div>

    {!! Form::label('motor_serial', 'Serial:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('motor_serial', null, ['class' => 'form-control', 'id' => 'motor_serial']) !!}
    </div>
  </div>
@stop

@section('mech-model-lift')
  <div class="form-group">
    {!! Form::label('model', 'Modelo:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('model', null, ['class' => 'form-control', 'id' => 'model']) !!}
    </div>
    
    {!! Form::label('lift', 'Capacidad (kg):', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('lift', null, ['class' => 'form-control', 'id' => 'lift']) !!}
    </div>
  </div>
@stop

@section('mech-cylinder-horse')
  <div class="form-group">
    {!! Form::label('cylinders', 'Cilindros:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('cylinders', null, ['class' => 'form-control', 'id' => 'cylinders']) !!}
    </div>

    {!! Form::label('horsepower', 'Caballaje:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('horsepower', null, ['class' => 'form-control', 'id' => 'horsepower']) !!}
    </div>
  </div>
@stop

@section('mech-mileage-traction')
  <div class="form-group">
    {!! Form::label('mileage', 'Kilometraje:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('mileage', null, ['class' => 'form-control', 'id' => 'mileage']) !!}
    </div>

    {!! Form::label('traction', 'Tracción:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('traction', null, ['class' => 'form-control', 'id' => 'traction']) !!}
    </div>
  </div>
@stop
