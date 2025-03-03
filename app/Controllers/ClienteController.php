<?php

namespace App\Controllers;

use Config\Services;
use App\Helpers\ApiResponse;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Services\Clientes\ClienteServiceInterface;
use App\Validators\Clientes\CreateClienteValidator;
use App\Validators\Clientes\UpdateClienteValidator;

class ClienteController extends BaseController
{
    use ResponseTrait;

    private ClienteServiceInterface $clienteService;

    public function __construct()
    {
        $this->clienteService = Services::clientesService();
    }

    public function index()
    {
        $clientes = $this->clienteService->getAll();
        return ApiResponse::success($clientes);
    }

    public function show(int $id)
    {
        $cliente = $this->clienteService->getById($id);

        if ($cliente) {
            return ApiResponse::success($cliente);
        }

        return ApiResponse::notFound('Cliente não encontrado');
    }

    public function store()
    {
        $clienteValidaor = new CreateClienteValidator($this->request, service('validation'));

        if (!$clienteValidaor->validate()) {
            return ApiResponse::unprocessableContent($clienteValidaor->getErrors());
        }

        $validatedData = $clienteValidaor->getValidatedData();

        return ApiResponse::created(
            $this->clienteService->create($validatedData)
        );
    }

    public function update()
    {
        $clienteValidaor = new UpdateClienteValidator($this->request, service('validation'));

        if (!$clienteValidaor->validate()) {
            return ApiResponse::unprocessableContent($clienteValidaor->getErrors());
        }

        $validatedData = $clienteValidaor->getValidatedData();
        $id = $this->request->getJsonVar('id');

        return ApiResponse::success(
            $this->clienteService->update($id, $validatedData)
        );
    }

    public function delete(int $id)
    {
        if ($this->clienteService->delete($id)) {
            return ApiResponse::noContent('Cliente excluído com sucesso');
        }

        return ApiResponse::notFound('Cliente não encontrado');
    }
}
