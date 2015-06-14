@include('feature.forms.common')

@yield('feature-title')
@yield('feature-description')
@yield('feature-image')
@yield('feature-file')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
