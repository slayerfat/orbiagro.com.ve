<?php


use Orbiagro\Http\Routes\UserRoutes as User;
use Orbiagro\Http\Routes\ProductRoutes as Product;
use Orbiagro\Http\Routes\CategoriesRoutes as Categories;
use Orbiagro\Http\Routes\MiscRoutes as Misc;

/**
 * @todo ver como mover esto a un ServiceProvider o algo similar.
 *
 * @see http://i62.tinypic.com/8wjf2u.jpg - MFW
 */

$routes = collect();

// se asume que el orden importa.
$routes->push(new User);
$routes->push(new Product);
$routes->push(new Categories);
$routes->push(new Misc);

$routes->each(function ($route) {
    $route->execute();
});
