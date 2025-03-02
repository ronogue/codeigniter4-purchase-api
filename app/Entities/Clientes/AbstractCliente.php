<?php

namespace App\Entities\Clientes;

use CodeIgniter\Entity\Entity;

abstract class AbstractCliente extends Entity
{
    protected $datamap = [
        'criadoEm' => 'criado_em',
        'atualizadoEm' => 'atualizado_em',
    ];
}
