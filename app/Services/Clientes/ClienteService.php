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

            $this->clienteModel->insert($this->clienteModel->filterByAllowedFields($data));

            $clienteId = $this->clienteModel->getInsertID();

            if ($data['tipo'] === 'PF') {

                $data = $this->pessoaFisica->filterByAllowedFields($data);
                $this->pessoaFisica->insert(array_merge(['id' => $clienteId], $data));
            } else {

                $data = $this->pessoaJuridica->filterByAllowedFields($data);
                $this->pessoaJuridica->insert(array_merge(['id' => $clienteId], $data));
            }

            return $this->getById($clienteId);
        });
    }

    public function update(int $id, array $data): AbstractCliente
    {
        return DBHelper::transaction(function () use ($id, $data) {

            $baseFields = $this->clienteModel->filterByAllowedFields($data);

            if (count($baseFields) > 0) {
                $this->clienteModel->update($id, $baseFields);
            }

            $cliente = $this->clienteModel->select('tipo')->where('id', $id)->first();

            if ($cliente['tipo'] === 'PF') {

                $updateData = $this->pessoaFisica->filterByAllowedFields($data);

                if (count($updateData) === 0) {
                    return $this->getById($id);
                }

                $this->pessoaFisica->update($id, $updateData);
            } else {

                $updateData = $this->pessoaJuridica->filterByAllowedFields($data);

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

    public function getAllPaginated(int $page, int $perPage = 10): PagedData
    {
        return $this->clienteModel->findAllPaginated($page, $perPage);
    }

    public function exists(int $id): bool
    {
        return $this->clienteModel->exists($id);
    }
}
