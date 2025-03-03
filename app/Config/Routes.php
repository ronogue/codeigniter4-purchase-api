<?php

use App\Controllers\ClienteController;
use App\Controllers\ProdutoController;
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

    $routes->group('produtos', function (RouteCollection $routes) {

        $routes->get('', [ProdutoController::class, 'index']);
        $routes->get('(:num)', [ProdutoController::class, 'show']);
        $routes->post('', [ProdutoController::class, 'store']);
        $routes->put('', [ProdutoController::class, 'update']);
        $routes->patch('', [ProdutoController::class, 'update']);
        $routes->delete('(:num)', [ProdutoController::class, 'delete']);
    });
});
