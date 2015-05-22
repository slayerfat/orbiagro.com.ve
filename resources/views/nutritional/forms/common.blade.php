@section('nutritional-due')
  <div class="form-group">
    {!! Form::label('due', 'Fecha de Vencimiento:', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9">
      {!! Form::input('date', 'due', null, ['class' => 'form-control', 'id' => 'due']) !!}
    </div>
  </div>
@stop
