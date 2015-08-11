@extends('master')

@section('css')
  <link rel="stylesheet" href="{!! asset('css/vendor/cropper.min.css') !!}" charset="utf-8">
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <img src="{!! asset($image->path) !!}" class="img-responsive" id="image">
      </div>
      <div class="col-md-4">
        <div>
          @include('errors.bag')
          {!! Form::open([
            'method' => 'PATCH',
            'action' => ['ImagesController@update', $image->id],
            'class' => 'form-horizontal',
            'files' => true
            ]) !!}

            <div class="form-group">
              {!! Form::label('image', 'Imagen:', ['class' => 'col-md-2 control-label']) !!}
              <div class="col-md-10">
                <input type="file" name="image" class="form-control" id="image" accept="image/*">
              </div>
            </div>

            <input type="text" name="dataX" value="">
            <input type="text" name="dataY" value="">
            <input type="text" name="dataHeight" value="">
            <input type="text" name="dataWidth" value="">
            <input type="text" name="dataRotate" value="">
            <input type="text" name="dataScaleX" value="">
            <input type="text" name="dataScaleY" value="">

            <input type="submit" value="Actualizar Imagen">
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/cropper.min.js') !!}"></script>
  <script type="text/javascript">
    $("#image").cropper({
      aspectRatio: 1,
      crop: function(e) {
        $('input[name="dataX"').val(Math.round(e.x));
        $('input[name="dataY"]').val(Math.round(e.y));
        $('input[name="dataHeight"]').val(Math.round(e.height));
        $('input[name="dataWidth"]').val(Math.round(e.width));
        $('input[name="dataRotate"]').val(e.rotate);
        $('input[name="dataScaleX"]').val(e.scaleX);
        $('input[name="dataScaleY"]').val(e.scaleY);
      }
    });
  </script>
@endsection
