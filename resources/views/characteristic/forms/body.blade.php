@include('characteristic.forms.common')

@yield('char-height')
@yield('char-width')
@yield('char-depth')
@yield('char-weight')
@yield('char-units')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
