<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataPinjamBarang extends Migration
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
                'constraint' => '50',
            ],
            'namaPeminjam' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'jumlahBarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'tanggalPinjam' => [
                'type'       => 'DATE'
            ],
            'waktuPinjam' => [
                'type'       => 'TIME',
            ],
            'tanggalKembali' => [
                'type'       => 'DATE',
                'null'      => true
            ],
            'waktuKembali' => [
                'type'       => 'TIME',
                'null'      => true
            ],
            'status' => [
                'type'  => 'ENUM("0","1")',
                'default'   => "0"
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
        $this->forge->createTable('dataPinjamBarang');
    }

    public function down()
    {
        $this->forge->dropTable('dataPinjamBarang');
    }
}
