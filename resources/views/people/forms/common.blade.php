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

@section('ic-nat')
  <div class="form-group">
    {!! Form::label('identity_card', 'Cedula de Identidad:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('identity_card', null, ['class' => 'form-control', 'id' => 'identity_card']) !!}
    </div>

    {!! Form::label('nationality_id', 'Nacionalidad:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::select('nationality_id', $nationalities, null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('gender-phone')
  <div class="form-group">
    {!! Form::label('gender_id', 'Genero:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::select('gender_id', $genders, null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::label('phone', 'Telefono de contacto:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
      {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone']) !!}
    </div>
  </div>
@stop

@section('birth_date')
  <div class="form-group">
    {!! Form::label('birth_date', 'Fecha de nacimiento:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::input('text', 'birth_date', $date, ['class' => 'form-control', 'data-date-format' => 'yyyy-mm-dd']) !!}
    </div>
  </div>
@endsection

@section('people-edit-css')
  <link href="{!! asset('css/vendor/datepicker.css') !!}" rel="stylesheet">
@endsection

@section('people-edit-js')
  <script type="text/javascript" src="{!! asset('js/vendor/bootstrap-datepicker.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/vendor/bootstrap-datepicker.es.js') !!}"></script>
  <script type="text/javascript">
    $('#birth_date').datepicker({
      language: 'es',
      format: 'yyyy-mm-dd'
    });
  </script>
@stop
