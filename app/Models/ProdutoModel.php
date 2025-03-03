<?php

namespace App\Models;

use App\Entities\Produtos\Produto;

class ProdutoModel extends BaseModel
{
    protected $table            = 'produtos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Produto::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'nome',
        'preco',
        'descricao',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'id' => 'int',
        'preco' => 'float',
    ];

    protected array $castHandlers = [];

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
