<?php

namespace App\Entities\Pedidos;

use App\Entities\BaseEntity;

class ItemPedido extends BaseEntity
{
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        $this->datamap = array_merge(
            $this->datamap,
            [
                'produtoId' => 'produto_id',
                'pedidoId' => 'pedido_id',
                'precoUnitario' => 'preco_unitario',
            ]
        );
    }
}
