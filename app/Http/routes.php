<?php


use Orbiagro\Http\Routes\UserRoutes;
use Orbiagro\Http\Routes\ProductRoutes;
use Orbiagro\Http\Routes\MiscRoutes;

/**
 * @todo ver como mover esto a un ServiceProvider o algo similar.
 *
 * @see http://i62.tinypic.com/8wjf2u.jpg - MFW
 */

$routes = collect();

// se asume que el orden importa.
$routes->push(new UserRoutes);
$routes->push(new ProductRoutes);
$routes->push(new MiscRoutes);

$routes->each(function ($route) {
    $route->execute();
});
