@include('sub-category.forms.common')

@yield('sub-cat-description')
@yield('sub-cat-info')
@yield('sub-cat-images')
@yield('sub-cat-categories')

<div class="form-group">
  <div class="col-md-12">
    {!! Form::submit($textoBotonSubmit, ['class' => 'form-control btn btn-primary']) !!}
  </div>
</div>
