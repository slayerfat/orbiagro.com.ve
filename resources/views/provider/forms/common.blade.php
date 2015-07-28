@section('name')
  <div class="form-group">
    {!! Form::label('name', 'Nombre:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('email')
  <div class="form-group">
    {!! Form::label('email', 'Correo electrónico:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('email', null, ['class' => 'form-control']) !!}
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

@section('trust')
  <div class="form-group">
    {!! Form::label('trust', 'Confianza:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::input('number', 'trust', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('phones')
  <div class="form-group">
    {!! Form::label('phone_1', 'Telefono:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('phone_1', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::label('phone_2', 'Telefono:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('phone_2', null, ['class' => 'form-control']) !!}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('phone_3', 'Telefono:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('phone_3', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::label('phone_4', 'Telefono:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('phone_4', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('contact')
  <div class="form-group">
    {!! Form::label('contact_title', 'Titulo del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('contact_title', null, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('contact_name', 'Nombre del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('contact_name', null, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('contact_email', 'Correo Electrónico del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('contact_email', null, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('contact_phone_1', 'Telefono del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('contact_phone_1', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::label('contact_phone_2', 'Telefono del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('contact_phone_2', null, ['class' => 'form-control']) !!}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('contact_phone_3', 'Telefono del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('contact_phone_3', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::label('contact_phone_4', 'Telefono del contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('contact_phone_4', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop
