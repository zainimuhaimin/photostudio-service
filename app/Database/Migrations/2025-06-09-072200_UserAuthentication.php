<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserAuthentication extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_role' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'created_at' => [
                'type'       => 'DATETIME'
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'SYSTEM'

            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'is_deleted' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => '0'
            ]
        ]);
        $this->forge->addPrimaryKey('id_user');
        $this->forge->createTable('user_authentication');
        $this->forge->addForeignKey('id_pelanggan', 'table_pelanggan', 'id_pelanggan');
        $this->forge->addForeignKey('id_role', 'role', 'id_role');
    }

    public function down()
    {
        //
        $this->forge->dropTable('user_authentication');
    }
}
