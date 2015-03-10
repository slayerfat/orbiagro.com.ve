<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Cambiar Navegacion</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        orbiagro.com.ve {!! env('APP_VERSION') !!}
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">Inicio</a></li>
        @unless (Auth::guest())
          @if (Auth::user()->perfil->description === 'Administrador')
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Usuarios
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>{!! link_to_action('UsersController@create', 'Crear') !!}</li>
                <li>{!! link_to_action('UsersController@index', 'Consulta General') !!}</li>
              </ul>
            </li>
          @endif
          @unless (Auth::user()->apartamentos()->get()->isEmpty())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Edificios
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                @if (Auth::user()->perfil->description === 'Administrador')
                  <li>{!! link_to_action('BuildingsController@create', 'Crear') !!}</li>
                  <li>{!! link_to_action('BuildingsController@index', 'Consulta General') !!}</li>
                @endif
                @foreach (Auth::user()->apartamentos as $apartamento)
                  <li>{!! link_to_action('BuildingsController@show', $apartamento->edificio->name, $apartamento->edificio->id) !!}</li>
                @endforeach
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Eventos
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                @if (Auth::user()->perfil->description === 'Administrador')
                  <li>{!! link_to_action('EventsController@create', 'Crear') !!}</li>
                  <li>{!! link_to_action('EventsController@index', 'Consulta General') !!}</li>
                @endif
                @foreach (Auth::user()->apartamentos as $apartamento)
                  <li>{!! link_to_action('BuildingsController@events', $apartamento->edificio->name, $apartamento->edificio->id) !!}</li>
                @endforeach
              </ul>
            </li>
          @endunless
        @endunless
      </ul>

      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
          <li><a href="/auth/login">Entrar</a></li>
          <li><a href="/auth/register">Registrarse</a></li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li>
                {!! link_to_action('UsersController@show', 'Perfil', Auth::user()->id) !!}
              </li>
              <li><a href="/auth/logout">Salir</a></li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
