<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TablePelanggan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pelanggan' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'no_telp' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP'
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'SYSTEM'
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'is_deleted' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
            ]
        ]);
        $this->forge->addKey('id_pelanggan', true);
        $this->forge->createTable('table_pelanggan');
    }

    public function down()
    {
        $this->forge->dropTable('table_pelanggan');
    }
}
