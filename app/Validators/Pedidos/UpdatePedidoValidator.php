<?php

namespace App\Validators\Pedidos;

use App\Validators\AbstractValidator;

class UpdatePedidoValidator extends AbstractValidator
{
    protected function rules(): array
    {
        return [
            'id' => [
                'label' => 'Id do Pedido',
                'rules' => 'required|integer|is_not_unique[pedidos.id]',
            ],
            'status' => [
                'label' => 'Status do Pedido',
                'rules' => 'if_exist|required|in_list[Em aberto,Pago,Cancelado]',
            ],
            'clienteId' => [
                'label' => 'Id do Cliente',
                'rules' => 'if_exist|required|integer|is_not_unique[clientes.id]',
            ],
            'dataPedido' => [
                'label' => 'Data do Pedido',
                'rules' => 'if_exist|required|date',
            ],
            'itens' => [
                'label' => 'Itens do Pedido',
                'rules' => 'if_exist|required',
            ],
            'itens.*.produtoId' => [
                'rules' => 'if_exist|required|integer|is_not_unique[produtos.id]',
            ],
            'itens.*.quantidade' => [
                'rules' => 'if_exist|required|integer|greater_than_equal_to[1]',
            ],
        ];
    }
}
