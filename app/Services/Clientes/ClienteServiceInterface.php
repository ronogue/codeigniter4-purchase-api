<?php

namespace App\Services\Clientes;

use App\Entities\PagedData;
use App\Entities\Clientes\AbstractCliente;

interface ClienteServiceInterface
{
    public function getAll(): PagedData;

    public function getById(int $id): ?AbstractCliente;

    public function create(array $data): AbstractCliente;

    public function update(int $id, array $data): AbstractCliente;

    public function delete(int $id): bool;
}
