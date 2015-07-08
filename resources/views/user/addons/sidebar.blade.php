<?php
switch ($active)
{
  case 'resumen':
    $resumen = 'class=active';
    break;
  case 'person':
    $person = 'class=active';
    break;
  case 'products':
    $products = 'class=active';
    break;
  case 'productsVisits':
    $productsVisits = 'class=active';
    break;
  case 'billing':
    $billing = 'class=active';
    break;
  default:
    Log::warning('user.addon.sidebar: no se pudo identificar el vinculo activo');
    break;}?>

<div class="col-sm-2 sidebar">
  <ul class="nav nav-sidebar">
    <li {{isset($resumen) ? $resumen:null}}>
      {!! link_to_action('UsersController@show', 'Resumen', $user->name) !!}
    </li>
    <li {{isset($products) ? $products:null}}>
      {!! link_to_action('UsersController@products', 'Productos', $user->name) !!}
    </li>
    @if(Auth::id() == $user->id || Auth::user()->isAdmin())
      {{-- <li {{isset($billing) ? $billing:null}}>
        <a href="#">Facturación</a>
      </li> --}}
      <li {{isset($productsVisits) ? $productsVisits:null}}>
        {!! link_to_action('UsersController@productVisits', 'Productos Visitados', $user->name) !!}
      </li>
    @endif
  </ul>
  @if(Auth::id() == $user->id || Auth::user()->isAdmin())
    <ul class="nav nav-sidebar">
      <li class="sidebar-header">
        Editar
      </li>
      <li>
        {!! link_to_action('UsersController@edit', 'Cuenta', $user->name) !!}
      </li>
      <li>
        {!! link_to_action($user->person ? 'PeopleController@edit':'PeopleController@create', 'Información Personal', $user->name) !!}
      </li>
      {{-- <li>
        <a href="#">Facturación</a>
      </li> --}}
      <li>
        <a href="#">Mas pronto!</a>
      </li>
    </ul>
  @endif
</div>
