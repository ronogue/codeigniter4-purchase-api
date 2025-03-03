<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class AddItensPedidoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'produto_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'pedido_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'quantidade' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'preco_unitario' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
            ],
            'criado_em' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'atualizado_em' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', '', 'CASCADE');

        $this->forge->createTable('itens_pedido');
        $this->forge->processIndexes('itens_pedido');
    }

    public function down()
    {
        $this->forge->dropTable('itens_pedido');
    }
}
