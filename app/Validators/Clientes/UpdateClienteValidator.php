<?php

namespace App\Validators\Clientes;

use App\Validators\AbstractValidator;

class UpdateClienteValidator extends AbstractValidator
{
    protected function rules(): array
    {
        $table = 'clientes_pessoa_fisica';
        $table_pf = 'clientes_pessoa_fisica';
        $table_pj = 'clientes_pessoa_juridica';
        $id = $this->request->getJsonVar('id');

        return [
            'id' => [
                'label' => 'ID',
                'rules' => "required|is_not_unique[$table.id]",
            ],
            'nome' => [
                'label' => 'Nome',
                'rules' => 'if_exist|required|min_length[3]|max_length[100]',
            ],
            'email' => [
                'label' => 'E-mail',
                'rules' => "if_exist|required|max_length[100]|valid_email|is_unique[$table.email,$table.id,$id]",
            ],
            'telefone' => [
                'label' => 'Telefone',
                'rules' => 'if_exist|required|min_length[10]|max_length[11]',
            ],
            'cpf' => [
                'label' => 'CPF',
                'rules' => "if_exist|required|min_length[11]|max_length[11]|is_unique[$table_pf.cpf,$table_pf.id,$id]",
            ],
            'cnpj' => [
                'label' => 'CNPJ',
                'rules' => "if_exist|required|min_length[14]|max_length[14]|is_unique[$table_pj.cnpj,$table_pj.id,$id]",
            ],
            'inscricaoEstadual' => [
                'label' => 'Inscrição Estadual',
                'rules' => "if_exist|required|min_length[8]|max_length[14]|is_unique[$table_pj.inscricao_estadual,$table_pj.id,$id]",
            ],
            'razaoSocial' => [
                'label' => 'Razão Social',
                'rules' => "if_exist|required|min_length[3]|max_length[255]|is_unique[$table_pj.razao_social,$table_pj.id,$id]",
            ],
        ];
    }
}
