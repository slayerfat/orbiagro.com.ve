@include('category.forms.common')

@yield('cat-description')
@yield('cat-info')
@yield('cat-images')
@yield('cat-categories')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
