<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TablePenyewaanAlat extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_penyewaan'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_alat'       => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'id_pelanggan' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'tanggal' => [
                'type'           => 'DATETIME',
            ],
            'total' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'created_by' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_by' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'is_deleted' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => 0,
            ]
        ]);
        $this->forge->addKey('id_penyewaan', true);
        $this->forge->createTable('table_penyewaan_alat');
    }

    public function down()
    {
        //
        $this->forge->dropTable('table_penyewaan_alat');
    }
}
