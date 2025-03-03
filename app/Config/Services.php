<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Services\Pedidos\PedidoService;
use App\Services\Clientes\ClienteService;
use App\Services\Produtos\ProdutoService;
use App\Services\Pedidos\ItemPedidoService;
use App\Services\Pedidos\PedidoServiceInterface;
use App\Services\Clientes\ClienteServiceInterface;
use App\Services\Produtos\ProdutoServiceInterface;
use App\Services\Pedidos\ItemPedidoServiceInterface;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function clientesService($getShared = true): ClienteServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('clientesService');
        }

        return new ClienteService();
    }

    public static function produtoService($getShared = true): ProdutoServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('produtoService');
        }

        return new ProdutoService();
    }

    public static function itemPedidoService($getShared = true): ItemPedidoServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('itemPedidoService');
        }

        return new ItemPedidoService();
    }

    public static function pedidoService($getShared = true): PedidoServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('pedidoService');
        }

        return new PedidoService(
            static::itemPedidoService($getShared),
            static::produtoService($getShared),
        );
    }
}
