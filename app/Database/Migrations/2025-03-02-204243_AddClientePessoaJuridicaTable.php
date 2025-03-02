<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class AddClientePessoaJuridicaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => false,
            ],
            'razao_social' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '14',
            ],
            'inscricao_estadual' => [
                'type' => 'VARCHAR',
                'constraint' => '14',
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
        $this->forge->addKey('cnpj');
        $this->forge->addKey('inscricao_estadual');
        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('clientes_pessoa_juridica');
        $this->forge->processIndexes('clientes_pessoa_juridica');
    }

    public function down()
    {
        $this->forge->dropTable('clientes_pessoa_juridica');
    }
}
