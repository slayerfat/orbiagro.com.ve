<form class="form-horizontal" role="form" method="POST" action="/auth/register">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="form-group">
    <label class="col-md-4 control-label">Seudónimo</label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="username" value="{{ old('username') }}">
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

  <div class="form-group">
    <div class="col-md-6 col-md-offset-4">
      <button type="submit" class="btn btn-primary">
        Registrarse
      </button>
    </div>
  </div>
</form>
