@include('mechanicalInfo.forms.common', [
  'title'       => null,
  'description' => null,
])

@yield('mech-motor-serial')
@yield('mech-model-lift')
@yield('mech-cylinder-horse')
@yield('mech-mileage-traction')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
