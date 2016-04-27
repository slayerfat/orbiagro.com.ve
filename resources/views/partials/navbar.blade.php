<nav class="navbar navbar-default" id="main-navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse-1">
        <span class="sr-only">Cambiar Navegacion</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        orbiagro.com.ve {!! env('APP_VERSION') !!}
      </a>
    </div>

    <div class="collapse navbar-collapse" id="main-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">Inicio</a></li>
        <li>
          {!! link_to_route('cats.index', 'Categorias') !!}
        </li>
        <li>
          {!! link_to_route('subCats.index', 'Rubros') !!}
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Productos
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            @unless(Auth::guest())
              <li>{!! link_to_route('products.create', 'Crear') !!}</li>
            @endunless
            <li>{!! link_to_route('products.index', 'Consultar') !!}</li>
          </ul>
        </li>
        @unless (Auth::guest())
          @if (Auth::user()->isAdmin())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Mant.
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>{!! link_to_route('users.create', 'Crear Usuario') !!}</li>
                <li>{!! link_to_route('users.index', 'Consultar Usuarios') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_route('profiles.create', 'Crear Perfil') !!}</li>
                <li>{!! link_to_route('profiles.index', 'Consultar Perfiles') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_route('subCats.create', 'Crear Rubro') !!}</li>
                <li>{!! link_to_route('cats.create', 'Crear Categoria') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_route('quantityTypes.create', 'Crear Tipo de cantidad') !!}</li>
                <li>{!! link_to_route('quantityTypes.index', 'Consultar Tipo de cantidad') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_route('makers.create', 'Crear Fabricante') !!}</li>
                <li>{!! link_to_route('makers.index', 'Consultar Fabricante') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_route('providers.create', 'Crear Proveedor') !!}</li>
                <li>{!! link_to_route('providers.index', 'Consultar Proveedor') !!}</li>
              </ul>
            </li>
          @endif
        @endunless
      </ul>

      <ul class="nav navbar-nav navbar-right" id="main-navbar-user">
        @if (Auth::guest())
          <li><a href="{{ url('/login') }}">Entrar</a></li>
          {{--<li><a href="{{ url('/register') }}">Registrarse</a></li>--}}
        @else
          <p class="navbar-text">Hola {{Auth::user()->name}}!</p>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li>
                {!! link_to_route('users.show', 'Perfil', Auth::user()->name) !!}
              </li>
              <li><a href="{{ url('/logout') }}">Salir</a></li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
