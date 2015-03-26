@extends('master')

@section('content')
  @include('partials.orbiagro-info')

  <div class="container-fluid bloque-4-4-4-info">
    <div class="container">
      <div class="row">

        <!-- elimina first child -->
        <div class="media"><div class="media-body"></div></div>
        <!-- importante -->

        <div class="media col-md-4">
          <a class="pull-left" href="#">
            <img class="media-object" src="http://placehold.it/128x128" alt="...">
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
            <img class="media-object" src="http://placehold.it/128x128" alt="...">
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
            <img class="media-object" src="http://placehold.it/128x128" alt="...">
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
          <img src="http://placehold.it/300x300">
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
