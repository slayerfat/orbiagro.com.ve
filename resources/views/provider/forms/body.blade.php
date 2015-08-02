@include('provider.forms.common')

@yield('name')
@yield('email')
@yield('url')
@yield('trust')
@yield('phones')
@yield('contact')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
