<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class AddProdutoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'descricao' => [
                'type' => 'TEXT',
            ],
            'preco' => [
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
        $this->forge->addKey('nome');

        $this->forge->createTable('produtos');
        $this->forge->processIndexes('produtos');
    }

    public function down()
    {
        $this->forge->dropTable('produtos');
    }
}
