@include('people.forms.common',[
  'date' => $user->person ? $user->person->date:null
])

@yield('names')
@yield('surnames')
@yield('ic-nat')
@yield('gender-phone')
@yield('birth_date')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
