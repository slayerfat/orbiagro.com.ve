<form class="form-horizontal" role="form" method="POST" action="/auth/register">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="form-group">
    <label class="col-md-4 control-label">Seudónimo</label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="username" value="{{ old('username') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Primer Nombre</label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Segundo Nombre</label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Primer Apellido</label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="first_surname" value="{{ old('first_surname') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Segundo Apellido</label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="last_surname" value="{{ old('last_surname') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Cedula</label>
    <div class="col-md-6">
      <input type="number" class="form-control" name="identity_card" value="{{ old('identity_card') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Correo Electrónico</label>
    <div class="col-md-6">
      <input type="email" class="form-control" name="email" value="{{ old('email') }}">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Contraseña</label>
    <div class="col-md-6">
      <input type="password" class="form-control" name="password">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label">Confirmar Contraseña</label>
    <div class="col-md-6">
      <input type="password" class="form-control" name="password_confirmation">
    </div>
  </div>

  <?php $sexos = \App\Sex::all() ?>

  <div class="form-group">
    <label class="col-md-4 control-label">Sexo</label>
    <div class="col-md-6">
      <select class="form-control" name="sex_id">
        @foreach ($sexos as $sexo)
          <option value="{{ $sexo->id }}">{{ $sexo->description }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-6 col-md-offset-4">
      <button type="submit" class="btn btn-primary">
        Registrarse
      </button>
    </div>
  </div>
</form>
