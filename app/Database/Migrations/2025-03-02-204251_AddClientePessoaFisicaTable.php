<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class AddClientePessoaFisicaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => false,
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
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

        $this->forge->addForeignKey('id', 'clientes', 'id', '', 'CASCADE');
        $this->forge->addKey('cpf');
        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('clientes_pessoa_fisica');
        $this->forge->processIndexes('clientes_pessoa_fisica');
    }

    public function down()
    {
        $this->forge->dropTable('clientes_pessoa_fisica');
    }
}
