@include('maker.forms.common')

@yield('name')
@yield('domain')
@yield('url')
@yield('image')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
