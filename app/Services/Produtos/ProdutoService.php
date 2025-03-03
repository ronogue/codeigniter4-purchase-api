<?php

namespace App\Services\Produtos;

use App\Entities\PagedData;
use App\Models\ProdutoModel;
use App\Entities\Produtos\Produto;

class ProdutoService implements ProdutoServiceInterface
{
    private ProdutoModel $produtoModel;

    public function __construct()
    {
        $this->produtoModel = model(ProdutoModel::class);
    }

    public function getAllPaginated(int $page, int $perPage = 10): PagedData
    {
        return $this->produtoModel->findAllPaginated($page, $perPage);
    }

    public function getById(int $id): ?Produto
    {
        return $this->produtoModel->find($id);
    }

    public function create(array $data): Produto
    {
        $dataToCreate = $this->produtoModel->filterByAllowedFields($data);
        $this->produtoModel->insert($dataToCreate);

        return $this->getById($this->produtoModel->getInsertID());
    }

    public function update(int $pedidoId, array $data): Produto
    {
        $dataToUpdate = $this->produtoModel->filterByAllowedFields($data);

        if (count($dataToUpdate) === 0) {
            return $this->getById($pedidoId);
        }

        $this->produtoModel->update($pedidoId, $dataToUpdate);

        return $this->getById($pedidoId);
    }

    public function delete(int $id): bool
    {
        return $this->produtoModel->delete($id);
    }

    public function exists(int $id): bool
    {
        return $this->produtoModel->exists($id);
    }
}
