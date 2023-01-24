<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kodeBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'namaBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'jenisBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'gambarBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '70',
            ],
            'stokBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
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
        $this->forge->createTable('dataBarang');
    }

    public function down()
    {
        $this->forge->dropTable('dataBarang');
    }
}