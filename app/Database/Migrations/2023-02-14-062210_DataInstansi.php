<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataInstansi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'namaInstansi' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'api' => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('instansi');
    }

    public function down()
    {
        $this->forge->dropTable('instansi');
    }
}
