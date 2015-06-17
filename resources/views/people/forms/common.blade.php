@section('names')
  <div class="form-group">
    {!! Form::label('first_name', 'Primer Nombre:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name']) !!}
    </div>

    {!! Form::label('last_name', 'Segundo Nombre:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name']) !!}
    </div>
  </div>
@stop

@section('surnames')
  <div class="form-group">
    {!! Form::label('first_surname', 'Primer Apellido:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('first_surname', null, ['class' => 'form-control', 'id' => 'first_surname']) !!}
    </div>

    {!! Form::label('last_surname', 'Segundo Apellido:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('last_surname', null, ['class' => 'form-control', 'id' => 'last_surname']) !!}
    </div>
  </div>
@stop

@section('ic-phone')
  <div class="form-group">
    {!! Form::label('identity_card', 'Cedula de Identidad:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('identity_card', null, ['class' => 'form-control', 'id' => 'identity_card']) !!}
    </div>

    {!! Form::label('phone', 'Telefono de contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone']) !!}
    </div>
  </div>
@stop
