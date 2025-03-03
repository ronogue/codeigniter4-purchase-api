<?php

namespace App\Validators\Produtos;

use App\Validators\AbstractValidator;

class CreateProdutoValidator extends AbstractValidator
{
    protected function rules(): array
    {
        return [
            'nome' => [
                'label' => 'Nome',
                'rules' => 'required|string|max_length[255]|is_unique[produtos.nome]',
            ],
            'preco' => [
                'label' => 'Preço',
                'rules' => 'required|numeric|greater_than_equal_to[0]',
            ],
            'descricao' => [
                'label' => 'Descrição',
                'rules' => 'required|string|max_length[1000]',
            ],
        ];
    }
}
