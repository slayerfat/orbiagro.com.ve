@extends('master')

@section('content')

<div class="container">
  <div class="carrusel-main">
    <div><img src="http://placehold.it/500/50" alt="" /></div>
    <div><img src="http://placehold.it/500/500" alt="" /></div>
    <div><img src="http://placehold.it/500/200" alt="" /></div>
  </div>
</div>

  @include('partials.orbiagro-info')

  <div class="container-fluid bloque-4-4-4-info">
    <div class="container">
      <div class="row">
        <!-- elimina first child -->
        <div class="media"><div class="media-body"></div></div>
        <!-- importante -->

        <div class="media col-md-4">
          <a class="pull-left" href="#">
            <img class="media-object" src="http://lorempizza.com/128/128" alt="...">
          </a>
          <div class="media-body">
            <h4 class="media-heading">Titulo de informacion</h4>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.
            <p>
              <a href="#">enlace</a>
            </p>
          </div>
        </div>
        <div class="media col-md-4">
          <a class="pull-left" href="#">
            <img class="media-object" src="http://lorempizza.com/128/128" alt="...">
          </a>
          <div class="media-body">
            <h4 class="media-heading">Titulo de informacion</h4>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.
            <p>
              <a href="#">enlace</a>
            </p>
          </div>
        </div>
        <div class="media col-md-4">
          <a class="pull-left" href="#">
            <img class="media-object" src="http://lorempizza.com/128/128" alt="...">
          </a>
          <div class="media-body">
            <h4 class="media-heading">Titulo de informacion</h4>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.
            <p>
              <a href="#">enlace</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="thumbnail">
          <img src="http://lorempizza.com/300/240">
          <div class="caption">
            <h3><a href="#">titulo del producto</a></h3>
            <p>
              Descripcion corta del producto
            </p>
            <p>
              <a href="#" class="btn btn-default">Mas informaci&oacute;n</a>
            </p>
          </div>
        </div>
      </div>
      </div>
    </div><!-- fin de row -->
  </div><!-- fin de container -->
@stop

@section('js')
  <script type="text/javascript" src="{!! asset('js/vendor/slick.min.js') !!}"></script>
  <script charset="utf-8">
    $(document).ready(function(){
      $('.carrusel-main').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true
      });
    });
  </script>
@stop
