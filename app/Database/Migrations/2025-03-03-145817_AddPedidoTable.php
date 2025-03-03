<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class AddPedidoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cliente_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Em Aberto', 'Pago', 'Cancelado'],
                'default' => 'Em Aberto',
            ],
            'data_pedido' => [
                'type' => 'DATE',
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id', '', 'CASCADE');

        $this->forge->addKey('status');
        $this->forge->addKey('data_pedido');

        $this->forge->createTable('pedidos');
        $this->forge->processIndexes('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos');
    }
}
