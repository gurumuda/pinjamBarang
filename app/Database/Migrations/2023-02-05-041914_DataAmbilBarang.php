<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataAmbilBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'idBarang' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'kodeBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'namaPengambil' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'jumlahBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
            ],
            'tanggalAmbil' => [
                'type'       => 'DATE'
            ],
            'waktuAmbil' => [
                'type'       => 'TIME',
            ],
            'keperluan' => [
                'type'       => 'TEXT',
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
        $this->forge->createTable('dataAmbilBarang');
    }

    public function down()
    {
        $this->forge->dropTable('dataAmbilBarang');
    }
}
