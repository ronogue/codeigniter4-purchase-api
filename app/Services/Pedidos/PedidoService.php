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
        $page = $this->pedidoModel->findAllPaginated($page, $perPage);
        $pedidosMap = [];

        foreach ($page->getData() as $pedido) {
            $pedidosMap[$pedido->id] = $pedido;
            $pedido->itens = [];
        }

        $pedidosIds = array_keys($pedidosMap);
        $itens = $this->itemPedidoService->findAllFrom($pedidosIds);

        foreach ($itens as $item) {
            $pedido = $pedidosMap[$item->pedido_id];
            $pedidosMap[$item->pedido_id]->itens = array_merge(
                $pedido->itens,
                [$item]
            );
        }

        return $page;
    }

    public function getById(int $id): ?Pedido
    {
        $pedido = $this->pedidoModel->find($id);

        if (!$pedido) {
            return null;
        }

        $pedido->itens = $this->itemPedidoService->findAllFrom($pedido->id);

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
            unset($pedidoDataToUpdate['total']);

            if (array_key_exists('itens', $data)) {

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

                $pedidoDataToUpdate = array_merge($pedidoDataToUpdate, [
                    'total' => $total
                ]);
            }

            $this->pedidoModel->update($pedidoId, $pedidoDataToUpdate);

            return $this->getById($pedidoId);
        });
    }

    public function delete(int $pedidoId): bool
    {
        return DBHelper::transaction(function () use ($pedidoId) {
            $this->itemPedidoService->deleteFrom($pedidoId);
            return $this->pedidoModel->delete($pedidoId);
        });
    }

    public function exists(int $id): bool
    {
        return $this->pedidoModel->exists($id);
    }
}
