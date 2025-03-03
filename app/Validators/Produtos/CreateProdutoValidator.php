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
                'rules' => 'required|string|max:255',
            ],
            'preco' => [
                'label' => 'Preço',
                'rules' => 'required|numeric|min:0',
            ],
            'descricao' => [
                'label' => 'Descrição',
                'rules' => 'required|string|max:1000',
            ],
        ];
    }
}
