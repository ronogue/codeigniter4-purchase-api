<?php

namespace App\Validators\Clientes;

use App\Validators\AbstractValidator;

class CreateClienteValidator extends AbstractValidator
{
    protected function rules(): array
    {
        $tipo = $this->request->getJsonVar('tipo');

        if ($tipo === 'PF') {
            return $this->pessoaFisicaRules();
        } elseif ($tipo === 'PJ') {
            return $this->pessoaJuridicaRules();
        }

        return $this->baseRules();
    }

    private function baseRules()
    {
        return [
            'nome' => [
                'label' => 'Nome',
                'rules' => 'required|min_length[3]|max_length[100]',
            ],
            'tipo' => [
                'label' => 'Tipo',
                'rules' => 'required|in_list[PF,PJ]',
            ],
            'email' => [
                'label' => 'E-mail',
                'rules' => 'required|max_length[100]|valid_email|is_unique[clientes.email]',
            ],
            'telefone' => [
                'label' => 'Telefone',
                'rules' => 'required|min_length[10]|max_length[11]',
            ],
        ];
    }

    private function pessoaFisicaRules()
    {
        return array_merge(
            $this->baseRules(),
            [
                'cpf' => [
                    'label' => 'CPF',
                    'rules' => 'required|min_length[11]|max_length[11]|is_unique[clientes.cpf]',
                ],
            ]
        );
    }

    private function pessoaJuridicaRules()
    {
        return array_merge(
            $this->baseRules(),
            [
                'cnpj' => [
                    'label' => 'CNPJ',
                    'rules' => 'required|min_length[14]|max_length[14]|is_unique[clientes.cnpj]',
                ],
                'inscricaoEstadual' => [
                    'label' => 'Inscrição Estadual',
                    'rules' => 'required|min_length[8]|max_length[14]|is_unique[clientes.inscricao_estadual]',
                ],
                'razaoSocial' => [
                    'label' => 'Razão Social',
                    'rules' => 'required|min_length[3]|max_length[255]|is_unique[clientes.razao_social]',
                ],
            ]
        );
    }
}
