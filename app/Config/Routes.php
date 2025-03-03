<?php

use App\Controllers\ClienteController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', function (RouteCollection $routes) {

    $routes->group('clientes', function (RouteCollection $routes) {

        $routes->get('', [ClienteController::class, 'index']);
        $routes->get('(:num)', [ClienteController::class, 'show']);
        $routes->post('', [ClienteController::class, 'store']);
        $routes->put('', [ClienteController::class, 'update']);
        $routes->patch('', [ClienteController::class, 'update']);
        $routes->delete('(:num)', [ClienteController::class, 'delete']);
    });
});
