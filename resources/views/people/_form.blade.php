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

<?php $sexes = \Orbiagro\Sex::all() ?>

<div class="form-group">
  <label class="col-md-4 control-label">Sexo</label>
  <div class="col-md-6">
    <select class="form-control" name="sex_id">
      @foreach ($sexes as $sex)
        <option value="{{ $sex->id }}">{{ $sex->description }}</option>
      @endforeach
    </select>
  </div>
</div>
