<?php

namespace App\Entities\Clientes;

class ClientePessoaFisica extends AbstractCliente
{
    public function __construct(?array $data = null)
    {
        parent::__construct([
            'id' => $data['id'],
            'nome' => $data['nome'],
            'tipo' => $data['tipo'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'cpf' => $data['cpf'],
            'criado_em' => $data['criado_em'],
            'atualizado_em' => $data['atualizado_em'],
        ]);
    }
}
