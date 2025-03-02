<?php

namespace App\Services\Clientes;

use App\Entities\PagedData;
use App\Models\ClienteModel;
use App\Entities\Clientes\AbstractCliente;

class ClienteService implements ClienteServiceInterface
{
    private ClienteModel $clienteModel;

    public function __construct()
    {
        $this->clienteModel = model(ClienteModel::class);
    }

    public function getById(int $id): ?AbstractCliente
    {
        return $this->clienteModel->findById($id);
    }

    public function getAll(): PagedData
    {
        return $this->clienteModel->findAllPaginated();
    }
}
