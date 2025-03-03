<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Helpers\ArrayKeys;
use App\Entities\PagedData;

class BaseModel extends Model
{
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    // protected $deletedField  = 'deleted_at';

    public function filterByAllowedFields(array $data): array
    {
        return ArrayKeys::pickKeys($data, $this->allowedFields);
    }

    public function findAllPaginated(int $page, int $perPage = 10): PagedData
    {
        $result = $this->paginate(perPage: $perPage, page: $page);
        return new PagedData($this->pager, $result);
    }
}
