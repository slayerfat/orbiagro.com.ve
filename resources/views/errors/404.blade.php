@extends('master')

@section('contenido')
  <div class="container-fluid full" id="cunaguaro">
    <div class="404">
      <div class="status">
        <h1>
          404
        </h1>
        <h2>
          Un Cunaguaro salvaje ha aparecido!
        </h2>
        <p>
          Lo lamentamos, pero la pagina solicitada no esta disponible.
        </p>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script type="text/javascript">
    $(function() {
      var navbar = parseInt($('.navbar').css('margin-bottom'));
      $('#cunaguaro').css({
        'background-image': 'url("{!! asset('img/cunaguaro.jpg') !!}")'
      });
      $('#cunaguaro').css({
        'background-size': parseInt($('#cunaguaro').css('background-size'))+50+'%'
      });
    });
  </script>
  <script src="{!! asset('js/404.js') !!}"></script>
@stop
