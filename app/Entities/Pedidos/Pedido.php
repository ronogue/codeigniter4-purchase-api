<?php

namespace App\Entities\Pedidos;

use App\Entities\BaseEntity;

class Pedido extends BaseEntity
{
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        $this->datamap = array_merge(
            $this->datamap,
            [
                'clienteId' => 'cliente_id',
                'dataPedido' => 'data_pedido',
            ]
        );
    }
}
