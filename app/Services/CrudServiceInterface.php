<?php

namespace App\Services;

use App\Entities\PagedData;
use App\Entities\BaseEntity;

/**
 * @template T of BaseEntity
 * @package App\Services
 */
interface CrudServiceInterface
{
    /**
     * @param int $id id do registro
     * @return T|null 
     */
    public function getById(int $id): ?BaseEntity;

    /**
     * @param array $data dados do registro
     * @return T 
     */
    public function create(array $data): BaseEntity;

    /**
     * @param int $id id do registro
     * @param array $data dados do registro
     * @return T 
     */
    public function update(int $id, array $data): BaseEntity;

    /**
     * @param int $id id do registro
     * @return bool true se foi excluído com sucesso
     */
    public function delete(int $id): bool;

    /**
     * @param int $id id do registro
     * @return bool true se o registro existe
     */
    public function exists(int $id): bool;
}
