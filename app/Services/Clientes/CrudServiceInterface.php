<?php

namespace App\Services\Clientes;

use App\Entities\PagedData;
use App\Entities\Clientes\AbstractCliente;

interface CrudServiceInterface
{
    public function getAllPaginated(int $page, int $perPage = 10): PagedData;

    public function getById(int $id): ?AbstractCliente;

    public function create(array $data): AbstractCliente;

    public function update(int $id, array $data): AbstractCliente;

    public function delete(int $id): bool;
}
