<?php

namespace App\Controllers;

use Config\Services;
use App\Helpers\ApiResponse;
use App\Controllers\BaseController;
use App\Services\Pedidos\PedidoServiceInterface;
use App\Validators\Pedidos\CreatePedidoValidator;
use App\Validators\Pedidos\UpdatePedidoValidator;

class PedidoController extends BaseController
{
    private PedidoServiceInterface $pedidoService;

    public function __construct()
    {
        $this->pedidoService = Services::pedidoService();
    }

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('perPage') ?? 10;

        return ApiResponse::success(
            $this->pedidoService->getAllPaginated($page, $perPage)
        );
    }

    public function show(int $id)
    {
        $produto = $this->pedidoService->getById($id);

        if ($produto) {
            return ApiResponse::success($produto);
        }

        return ApiResponse::notFound('Pedido não encontrado');
    }

    public function store()
    {
        $produtoValidaor = new CreatePedidoValidator($this->request, service('validation'));

        if (!$produtoValidaor->validate()) {
            return ApiResponse::unprocessableContent($produtoValidaor->getErrors());
        }

        $validatedData = $produtoValidaor->getValidatedData();

        return ApiResponse::created(
            $this->pedidoService->create($validatedData)
        );
    }

    public function update()
    {
        $produtoValidaor = new UpdatePedidoValidator($this->request, service('validation'));

        if (!$produtoValidaor->validate()) {
            return ApiResponse::unprocessableContent($produtoValidaor->getErrors());
        }

        $id = $this->request->getJsonVar('id');

        if (!$this->pedidoService->exists($id)) {
            return ApiResponse::notFound('Pedido não encontrado');
        }

        $validatedData = $produtoValidaor->getValidatedData();

        return ApiResponse::success(
            $this->pedidoService->update($id, $validatedData)
        );
    }

    public function delete(int $id)
    {
        if (!$this->pedidoService->exists($id)) {
            return ApiResponse::notFound('Pedido não encontrado');
        }

        $this->pedidoService->delete($id);

        return ApiResponse::noContent();
    }
}
