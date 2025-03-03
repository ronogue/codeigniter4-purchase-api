<?php

namespace App\Validators\Pedidos;

use App\Validators\AbstractValidator;

class CreatePedidoValidator extends AbstractValidator
{
    protected function rules(): array
    {
        return [
            'clienteId' => [
                'label' => 'Id do Cliente',
                'rules' => 'required|integer|is_not_unique[clientes.id]',
            ],
            'status' => [
                'label' => 'Status do Pedido',
                'rules' => 'required|in_list[Em aberto,Pago,Cancelado]',
            ],
            'dataPedido' => [
                'label' => 'Data do Pedido',
                'rules' => 'required|date',
            ],
            'itens' => [
                'label' => 'Itens do Pedido',
                'rules' => 'required',
            ],
            'itens.*.produtoId' => [
                'rules' => 'required|integer|is_not_unique[produtos.id]',
            ],
            'itens.*.quantidade' => [
                'rules' => 'required|integer|greater_than_equal_to[1]',
            ],
        ];
    }
}
