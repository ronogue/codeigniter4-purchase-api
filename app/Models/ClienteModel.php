<?php

namespace App\Models;

use App\Entities\PagedData;
use App\Entities\Clientes\ClientePessoaFisica;
use App\Entities\Clientes\ClientePessoaJuridica;

class ClienteModel extends BaseModel
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'nome',
        'tipo',
        'email',
        'telefone',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'id' => 'int',
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

    private function createBaseQuery()
    {
        $this->select('clientes.*, pf.cpf, pj.cnpj, pj.inscricao_estadual, pj.razao_social');

        $this->join(
            'clientes_pessoa_fisica as pf',
            'clientes.id = pf.id',
            'left'
        );

        $this->join(
            'clientes_pessoa_juridica as pj',
            'clientes.id = pj.id',
            'left'
        );
    }

    private function mapCliente(array $cliente): ClientePessoaFisica|ClientePessoaJuridica
    {
        if ($cliente['tipo'] === 'PF') {
            return new ClientePessoaFisica($cliente);
        }

        return new ClientePessoaJuridica($cliente);
    }

    private function mapResults(array $clientes): array
    {
        $result = [];

        foreach ($clientes as $cliente) {
            $result[] = $this->mapCliente($cliente);
        }

        return $result;
    }

    public function findAllPaginated(int $page, int $perPage = 10): PagedData
    {
        $this->createBaseQuery();

        $result = $this->mapResults($this->paginate(perPage: $perPage, page: $page));

        return new PagedData($this->pager, $result);
    }

    public function findById(int $id): ClientePessoaFisica|ClientePessoaJuridica|null
    {
        $this->createBaseQuery();

        $result = $this->find($id);

        if ($result) {
            return $this->mapCliente($result);
        }

        return null;
    }
}
