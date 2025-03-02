<?php

namespace App\Controllers;

use Config\Services;
use App\Helpers\ApiResponse;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Validators\Clientes\CreateClienteValidator;

class ClienteController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $clienteService = Services::clientesService();
        $clientes = $clienteService->getAll();

        return ApiResponse::success($clientes);
    }

    public function show(int $id)
    {
        $clienteService = Services::clientesService();
        $cliente = $clienteService->getById($id);

        if ($cliente) {
            return ApiResponse::success($cliente);
        }

        return ApiResponse::notFound('Cliente não encontrado');
    }

    public function store()
    {
        $clienteValidaor = new CreateClienteValidator($this->request, service('validation'));

        if (!$clienteValidaor->validate()) {
            return ApiResponse::unprocessableContent(
                $clienteValidaor->getErrors()
            );
        }

        $validatedData = $clienteValidaor->getValidatedData();
        return ApiResponse::created($validatedData);
    }
}
