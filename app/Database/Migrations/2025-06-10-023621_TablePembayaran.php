<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TablePembayaran extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_pembayaran'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penyewaan'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true,
            ],
            'id_pemensanan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true,
            ],
            'transaction_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
            ],
            'metode_pembayaran' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'tanggal_pembayaran' => [
                'type'           => 'DATE',
                'null'           => true,
            ],
            'bukti_pembayaran' => [
                'type'           => 'BLOB',
                'null'           => true,
            ],
            'status_pembayaran' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
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
                'default'        => 'SYSTEM'
            ],
            'is_deleted'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default'        => 0,
            ]
        ]);
        $this->forge->addKey('id_pembayaran', true);
        $this->forge->createTable('table_pembayaran');
    }

    public function down()
    {
        //
        $this->forge->dropTable('table_pembayaran');
    }
}
