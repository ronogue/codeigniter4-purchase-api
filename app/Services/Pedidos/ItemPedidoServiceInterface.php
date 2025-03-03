<?php

namespace App\Services\Pedidos;

use App\Entities\Pedidos\ItemPedido;
use App\Services\CrudServiceInterface;

interface ItemPedidoServiceInterface extends CrudServiceInterface
{
    public function findAllFrom(array|int $pedido): array;

    public function findBy(int $pedidoId, int $produtoId, array|string $columns = '*'): ?ItemPedido;

    public function deleteAllExcept(array $ids, int $pedidoId): bool;

    public function deleteFrom(int $pedidoId): bool;
}
