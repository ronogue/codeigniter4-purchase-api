<?php

namespace App\Services\Clientes;

use App\Helpers\DBHelper;
use App\Entities\PagedData;
use App\Models\ClienteModel;
use App\Models\ClientePessoaFisicaModel;
use App\Entities\Clientes\AbstractCliente;
use App\Models\ClientePessoaJuridicaModel;

class ClienteService implements ClienteServiceInterface
{
    private ClienteModel $clienteModel;
    private ClientePessoaFisicaModel $pessoaFisica;
    private ClientePessoaJuridicaModel $pessoaJuridica;

    public function __construct()
    {
        $this->clienteModel = model(ClienteModel::class);
        $this->pessoaFisica = model(ClientePessoaFisicaModel::class);
        $this->pessoaJuridica = model(ClientePessoaJuridicaModel::class);
    }

    public function create(array $data): AbstractCliente
    {
        return DBHelper::transaction(function () use ($data) {

            $this->clienteModel->insert($data);
            $clienteId = $this->clienteModel->getInsertID();

            if ($data['tipo'] === 'PF') {
                $this->pessoaFisica->insert([
                    'id' => $clienteId,
                    'cpf' => $data['cpf'],
                ]);
            } else {
                $this->pessoaJuridica->insert([
                    'id' => $clienteId,
                    'cnpj' => $data['cnpj'],
                    'inscricao_estadual' => $data['inscricao_estadual'],
                ]);
            }

            return $this->getById($clienteId);
        });
    }

    public function getById(int $id): ?AbstractCliente
    {
        return $this->clienteModel->findById($id);
    }

    public function getAll(): PagedData
    {
        return $this->clienteModel->findAllPaginated();
    }
}
