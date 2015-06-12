@include('user.forms.common')

@yield('user-name')
@yield('user-email')
@yield('user-password')
@yield('user-profile')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
