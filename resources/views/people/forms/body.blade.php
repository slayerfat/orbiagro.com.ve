@include('people.forms.common')

@yield('names')
@yield('surnames')
@yield('ic-phone')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
