<?php

namespace App\Services\Pedidos;

use App\Helpers\DBHelper;
use App\Entities\PagedData;
use App\Entities\Pedidos\Pedido;
use App\Models\Pedidos\PedidoModel;
use App\Services\Produtos\ProdutoServiceInterface;

class PedidoService implements PedidoServiceInterface
{
    private PedidoModel $pedidoModel;
    private ItemPedidoServiceInterface $itemPedidoService;
    private ProdutoServiceInterface $produtoService;

    public function __construct(
        ItemPedidoServiceInterface $itemPedidoService,
        ProdutoServiceInterface $produtoService
    ) {
        $this->pedidoModel = model(PedidoModel::class);
        $this->itemPedidoService = $itemPedidoService;
        $this->produtoService = $produtoService;
    }

    public function getAllPaginated(int $page, int $perPage = 10): PagedData
    {
        return $this->pedidoModel->findAllPaginated($page, $perPage);
    }

    public function getById(int $id): ?Pedido
    {
        $pedido = $this->pedidoModel->find($id);
        $pedido->itens = $this->itemPedidoService->findAllFrom($pedido);

        return $pedido;
    }

    public function create(array $data): Pedido
    {
        return DBHelper::transaction(function () use ($data) {

            $this->pedidoModel->insert(
                $this->pedidoModel->filterByAllowedFields($data)
            );

            $pedidoId = $this->pedidoModel->getInsertID();
            $total = 0;

            foreach ($data['itens'] as $item) {

                $produto = $this->produtoService->getById($item['produto_id']);
                $total += $produto->preco * $item['quantidade'];

                $this->itemPedidoService->create(array_merge(
                    $item,
                    [
                        'pedido_id' => $pedidoId,
                        'preco_unitario' => $produto->preco
                    ]
                ));
            }

            $this->pedidoModel->update($pedidoId, [
                'total' => $total
            ]);

            return $this->getById($pedidoId);
        });
    }

    public function update(int $pedidoId, array $data): Pedido
    {
        return DBHelper::transaction(function () use ($pedidoId, $data) {

            $pedidoDataToUpdate = $this->pedidoModel->filterByAllowedFields($data);

            $itensIds = [];
            $total = 0;

            foreach ($data['itens'] as $item) {

                $itemId = null;

                $produto = $this->produtoService->getById($item['produto_id']);
                $total += $produto->preco * $item['quantidade'];

                $itemData = array_merge(
                    $item,
                    [
                        'pedido_id' => $pedidoId,
                        'preco_unitario' => $produto->preco
                    ]
                );

                $itemToUpdate = $this->itemPedidoService->findBy(
                    $pedidoId,
                    $item['produto_id'],
                    'id'
                );

                if ($itemToUpdate) {
                    $itemId = $itemToUpdate->id;
                    $this->itemPedidoService->update($itemToUpdate->id, $itemData);
                } else {
                    $itemId = $this->itemPedidoService->create($itemData)->id;
                }

                $itensIds[] = $itemId;
            }

            $this->itemPedidoService->deleteAllExcept($itensIds, $pedidoId);

            $this->pedidoModel->update($pedidoId, array_merge($pedidoDataToUpdate, [
                'total' => $total
            ]));

            return $this->getById($pedidoId);
        });
    }

    public function delete(int $id): bool
    {
        return $this->pedidoModel->delete($id);
    }

    public function exists(int $id): bool
    {
        return $this->pedidoModel->exists($id);
    }
}
