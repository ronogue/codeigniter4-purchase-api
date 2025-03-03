<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Helpers\ArrayKeys;

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
}
