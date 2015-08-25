<?php


/**
 * @todo ver como mover esto a un ServiceProvider o algo similar.
 *
 * @see http://i62.tinypic.com/8wjf2u.jpg - MFW
 */

$routes = collect();

// se asume que el orden importa.
$routes->push(new Orbiagro\Http\Routes\UserRoutes);
$routes->push(new Orbiagro\Http\Routes\ProductRoutes);
$routes->push(new Orbiagro\Http\Routes\MiscRoutes);

$routes->each(function ($route) {
    $route->execute();
});
