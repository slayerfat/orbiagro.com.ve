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
        {{-- <li class="dropdown"> --}}
        <li>
          {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Categorias
            <span class="caret"></span>
          </a> --}}
          {{-- <ul class="dropdown-menu" role="menu"> --}}
            {{-- <li>{!! link_to_action('CategoriesController@index', 'Consultar') !!}</li> --}}
          {{-- </ul> --}}
          {!! link_to_action('CategoriesController@index', 'Categorias') !!}
        </li>
        {{-- <li class="dropdown"> --}}
        <li>
          {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Rubros
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li>{!! link_to_action('SubCategoriesController@index', 'Consultar') !!}</li>
          </ul> --}}
          {!! link_to_action('SubCategoriesController@index', 'Rubros') !!}
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Productos
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            @unless(Auth::guest())
              <li>{!! link_to_action('ProductsController@create', 'Crear') !!}</li>
            @endunless
            <li>{!! link_to_action('ProductsController@index', 'Consultar') !!}</li>
          </ul>
        </li>
        @unless (Auth::guest())
          @if (Auth::user()->isAdmin())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Mantenimiento
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>{!! link_to_action('UsersController@create', 'Crear Usuario') !!}</li>
                <li>{!! link_to_action('UsersController@index', 'Consultar Usuarios') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_action('ProfilesController@create', 'Crear Perfil') !!}</li>
                <li>{!! link_to_action('ProfilesController@index', 'Consultar Perfiles') !!}</li>
                <li class="divider"></li>
                <li>{!! link_to_action('SubCategoriesController@create', 'Crear Rubro') !!}</li>
                <li>{!! link_to_action('CategoriesController@create', 'Crear Categoria') !!}</li>
              </ul>
            </li>
          @endif
        @endunless
      </ul>

      <ul class="nav navbar-nav navbar-right" id="main-navbar-user">
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
