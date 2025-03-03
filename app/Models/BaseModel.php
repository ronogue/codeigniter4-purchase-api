<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Helpers\ArrayKeys;

class BaseModel extends Model
{
    public function filterByAllowedFields(array $data): array
    {
        return ArrayKeys::pickKeys($data, $this->allowedFields);
    }
}
