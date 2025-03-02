<?php

namespace App\Services\Clientes;

use App\Helpers\DBHelper;
use App\Helpers\ArrayKeys;
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

                $data = ArrayKeys::pickKeys($data, ['cpf']);

                $this->pessoaFisica->insert(array_merge([
                    'id' => $clienteId
                ], $data));
            } else {

                $data = ArrayKeys::pickKeys($data, ['cnpj', 'inscricao_estadual', 'razao_social']);

                $this->pessoaJuridica->insert(array_merge([
                    'id' => $clienteId,
                ], $data));
            }

            return $this->getById($clienteId);
        });
    }

    public function update(int $id, array $data): AbstractCliente
    {
        return DBHelper::transaction(function () use ($id, $data) {

            $this->clienteModel->update($id, $data);

            if ($data['tipo'] === 'PF') {

                $updateData = ArrayKeys::pickKeys($data, ['cpf']);

                if (count($updateData) === 0) {
                    return $this->getById($id);
                }

                $this->pessoaFisica->update($id, $updateData);
            } else {

                $updateData = ArrayKeys::pickKeys(
                    $data,
                    ['cnpj', 'inscricao_estadual', 'razao_social']
                );

                if (count($updateData) === 0) {
                    return $this->getById($id);
                }

                $this->pessoaJuridica->update($id, $updateData);
            }

            return $this->getById($id);
        });
    }

    public function delete(int $id): bool
    {
        return DBHelper::transaction(function () use ($id) {

            $this->pessoaFisica->delete($id);
            $this->pessoaJuridica->delete($id);

            return $this->clienteModel->delete($id);
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
