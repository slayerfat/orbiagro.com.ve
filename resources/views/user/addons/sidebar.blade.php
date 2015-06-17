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
  case 'billing':
    $billing = 'class=active';
    break;
  default:
    Log::warning('user.addon.sidebar: no se pudo identificar el vinculo activo');
    break;}?>

<div class="col-sm-2 sidebar">
  <ul class="nav nav-sidebar">
    <li {{isset($resumen) ? $resumen:null}}>
      <a href="#">Resumen</a>
    </li>
    <li {{isset($products) ? $products:null}}>
      <a href="#">Productos</a>
    </li>
    <li {{isset($billing) ? $billing:null}}>
      <a href="#">Facturación</a>
    </li>
  </ul>

  <ul class="nav nav-sidebar">
    <li class="sidebar-header">
      Editar
    </li>
    <li>
      {!! link_to_action('UsersController@edit', 'Cuenta', $user->name) !!}
    </li>
    <li>
      @if($user->person)
        {!! link_to_action('PeopleController@edit', 'Información Personal', $user->name) !!}
      @else
        {!! link_to_action('PeopleController@create', 'Información Personal') !!}
      @endif
    </li>
    <li>
      <a href="#">Facturación</a>
    </li>
    <li>
      <a href="#">Mas pronto!</a>
    </li>
  </ul>
</div>
