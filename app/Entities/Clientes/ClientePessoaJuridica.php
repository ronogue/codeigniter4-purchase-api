<?php

namespace App\Entities\Clientes;

class ClientePessoaJuridica extends AbstractCliente
{
    public function __construct(?array $data)
    {
        parent::__construct([
            'id' => $data['id'],
            'nome' => $data['nome'],
            'tipo' => $data['tipo'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'cnpj' => $data['cnpj'],
            'inscricao_estadual' => $data['inscricao_estadual'],
            'razao_social' => $data['razao_social'],
            'criado_em' => $data['criado_em'],
            'atualizado_em' => $data['atualizado_em'],
        ]);

        $this->datamap = array_merge([
            'inscricaoEstadual' => 'inscricao_estadual',
            'razaoSocial' => 'razao_social'
        ], $this->datamap);
    }
}
