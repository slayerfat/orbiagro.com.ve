<?php
$resumen = null;
$person = null;
$products = null;
$billing = null;
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
    break;
}

?>

<div class="col-sm-2 sidebar">
  <ul class="nav nav-sidebar">
    <li {{$resumen}}>
      <a href="#">Resumen</a>
    </li>
    <li {{$person}}>
      <a href="#">Información Personal</a>
    </li>
    <li {{$products}}>
      <a href="#">Productos</a>
    </li>
    <li {{$billing}}>
      <a href="#">Facturación</a>
    </li>
  </ul>

  <ul class="nav nav-sidebar">
    <li class="sidebar-header">
      Editar
    </li>
    <li>
      <a href="#">Información Personal</a>
    </li>
    <li>
      <a href="#">Cuenta</a>
    </li>
    <li>
      <a href="#">Facturación</a>
    </li>
    <li>
      <a href="#">Mas pronto!</a>
    </li>
  </ul>
</div>
