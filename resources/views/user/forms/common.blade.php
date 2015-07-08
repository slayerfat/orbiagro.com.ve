@section('user-name')
  <div class="form-group">
    {!! Form::label('name', 'Seudónimo:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('user-email')
  <div class="form-group">
    {!! Form::label('email', 'Correo Electrónico:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('user-password')
  <div class="form-group">
    {!! Form::label('password', 'Contraseña:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('password_confirmation', 'Confirmar Contraseña:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop

@section('user-profile')
  @if(Auth::user() and Auth::user()->isAdmin())
    <div class="form-group">
      {!! Form::label('profile_id', 'Perfil:', ['class' => 'col-md-2 control-label']) !!}
      <div class="col-md-10">
        {!! Form::select('profile_id', $profiles, null, ['class' => 'form-control']) !!}
      </div>
    </div>
  @endif
@stop
