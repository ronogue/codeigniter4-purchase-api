<?php

namespace App\Services\Pedidos;

use App\Entities\Pedidos\ItemPedido;
use App\Models\Pedidos\ItemPedidoModel;

class ItemPedidoService implements ItemPedidoServiceInterface
{
    private ItemPedidoModel $itemPedidoModel;

    public function __construct()
    {
        $this->itemPedidoModel = model(ItemPedidoModel::class);
    }

    public function findBy(int $pedidoId, int $produtoId, array|string $columns = '*'): ?ItemPedido
    {
        if (is_array($columns)) {
            $this->itemPedidoModel->select(implode(',', $columns));
        }

        return $this->itemPedidoModel->where('pedido_id', $pedidoId)
            ->where('produto_id', $produtoId)
            ->first();
    }

    public function getById(int $id): ?ItemPedido
    {
        return $this->itemPedidoModel->find($id);
    }

    public function create(array $data): ItemPedido
    {
        $this->itemPedidoModel->insert(
            $this->itemPedidoModel->filterByAllowedFields($data)
        );

        $id = $this->itemPedidoModel->getInsertID();

        return $this->getById($id);
    }

    public function update(int $pedidoId, array $data): ItemPedido
    {
        $dataToUpdate = $this->itemPedidoModel->filterByAllowedFields($data);

        if (count($dataToUpdate) === 0) {
            return $this->getById($pedidoId);
        }

        $this->itemPedidoModel->update($pedidoId, $dataToUpdate);

        return $this->getById($pedidoId);
    }

    public function exists(int $id): bool
    {
        return $this->itemPedidoModel->exists($id);
    }

    public function findAllFrom(array|int $pedido): array
    {
        return $this->itemPedidoModel->findAllFrom($pedido);
    }

    public function delete(int $id): bool
    {
        return $this->itemPedidoModel->delete($id);
    }

    public function deleteAllExcept(array $ids, int $pedidoId): bool
    {
        return $this->itemPedidoModel
            ->where('pedido_id', $pedidoId)
            ->whereNotIn('id', $ids)
            ->delete();
    }

    public function deleteFrom(int $pedidoId): bool
    {
        return $this->itemPedidoModel->where('pedido_id', $pedidoId)->delete();
    }
}
