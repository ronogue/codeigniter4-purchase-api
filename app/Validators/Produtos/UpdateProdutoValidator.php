<?php

namespace App\Validators\Produtos;

use App\Validators\AbstractValidator;

class UpdateProdutoValidator extends AbstractValidator
{
    protected function rules(): array
    {
        $id = $this->request->getJsonVar("id");

        return [
            'id' => [
                'label' => 'ID',
                'rules' => 'required|integer|is_not_unique[produtos.id]',
            ],
            'nome' => [
                'label' => 'Nome',
                'rules' => "if_exist|required|string|max_length[255]|is_unique[produtos.nome,id,$id]",
            ],
            'preco' => [
                'label' => 'Preço',
                'rules' => 'if_exist|required|numeric|greater_than_equal_to[0]',
            ],
            'descricao' => [
                'label' => 'Descrição',
                'rules' => 'if_exist|required|string|min_length[1000]',
            ],
        ];
    }
}
