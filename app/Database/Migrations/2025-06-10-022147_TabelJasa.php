<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelJasa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jasa'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jasa'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'harga_jasa' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'deskripsi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'created_by' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'default'        => 'SYSTEM'
            ],
            'updated_by' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'default'        => 'SYSTEM'
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'is_deleted' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => 0,
            ]
        ]);
        $this->forge->addKey('id_jasa', true);
        $this->forge->createTable('table_jasa');
    }

    public function down()
    {
        $this->forge->dropTable('table_jasa');
    }
}
