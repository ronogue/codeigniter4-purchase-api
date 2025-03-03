<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BaseEntity extends Entity
{
    protected $datamap = [
        'criadoEm' => 'criado_em',
        'atualizadoEm' => 'atualizado_em',
    ];
}
