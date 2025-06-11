<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TablePemensananJasa extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_pemensanan'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_jasa'       => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'id_pelanggan'       => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'tanggal'       => [
                'type'           => 'DATETIME',
            ],
            'total'       => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->addKey('id_pemensanan', true);
        $this->forge->createTable('table_pemensanan_jasa');
    }

    public function down()
    {
        //
        $this->forge->dropTable('table_pemensanan_jasa');
    }
}
