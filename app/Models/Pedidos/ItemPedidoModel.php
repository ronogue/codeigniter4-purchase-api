<?php

namespace App\Models\Pedidos;

use App\Models\BaseModel;
use App\Entities\Pedidos\ItemPedido;

class ItemPedidoModel extends BaseModel
{
    protected $table            = 'itens_pedido';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ItemPedido::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'produto_id',
        'pedido_id',
        'quantidade',
        'preco_unitario',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'id' => 'int',
        'produto_id' => 'int',
        'pedido_id' => 'int',
        'quantidade' => 'int',
        'preco_unitario' => 'float',
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

    public function findAllFrom(array|int $pedido): array
    {
        if (is_array($pedido)) {
            $this->whereIn('pedido_id', $pedido);
        } else {
            $this->where('pedido_id', $pedido);
        }

        return $this->findAll();
    }
}
