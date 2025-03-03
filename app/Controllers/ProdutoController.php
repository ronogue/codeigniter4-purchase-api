<?php

namespace App\Controllers;

use Config\Services;
use App\Helpers\ApiResponse;
use App\Controllers\BaseController;
use App\Services\Produtos\ProdutoServiceInterface;
use App\Validators\Produtos\CreateProdutoValidator;
use App\Validators\Produtos\UpdateProdutoValidator;

class ProdutoController extends BaseController
{
    private ProdutoServiceInterface $produtoService;

    public function __construct()
    {
        $this->produtoService = Services::produtoService();
    }

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('perPage') ?? 10;

        return ApiResponse::success(
            $this->produtoService->getAllPaginated($page, $perPage)
        );
    }

    public function show(int $id)
    {
        $produto = $this->produtoService->getById($id);

        if ($produto) {
            return ApiResponse::success($produto);
        }

        return ApiResponse::notFound('Produto não encontrado');
    }

    public function store()
    {
        $produtoValidaor = new CreateProdutoValidator($this->request, service('validation'));

        if (!$produtoValidaor->validate()) {
            return ApiResponse::unprocessableContent($produtoValidaor->getErrors());
        }

        $validatedData = $produtoValidaor->getValidatedData();

        return ApiResponse::created(
            $this->produtoService->create($validatedData)
        );
    }

    public function update()
    {
        $produtoValidaor = new UpdateProdutoValidator($this->request, service('validation'));

        if (!$produtoValidaor->validate()) {
            return ApiResponse::unprocessableContent($produtoValidaor->getErrors());
        }

        $id = $this->request->getJsonVar('id');

        if (!$this->produtoService->exists($id)) {
            return ApiResponse::notFound('Produto não encontrado');
        }

        $validatedData = $produtoValidaor->getValidatedData();

        return ApiResponse::success(
            $this->produtoService->update($id, $validatedData)
        );
    }

    public function delete(int $id)
    {
        if (!$this->produtoService->exists($id)) {
            return ApiResponse::notFound('Produto não encontrado');
        }

        $this->produtoService->delete($id);

        return ApiResponse::noContent();
    }
}
