<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableAlat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alat'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_alat'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'harga_alat'       => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'deskripsi'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'image_path'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true,
            ],
            'created_at'       => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'created_by'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'default'        => 'SYSTEM'
            ],
            'updated_at'       => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_by'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true,
            ],
            'is_deleted'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => 0,
            ]
        ]);
        $this->forge->addKey('id_alat', true);
        $this->forge->createTable('table_alat');
    }

    public function down()
    {
        //
        $this->forge->dropTable('table_alat');
    }
}
