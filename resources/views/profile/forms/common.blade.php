@section('description')
  <div class="form-group">
    {!! Form::label('description', 'Descripción:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>
  </div>
@stop
