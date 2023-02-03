<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DaftarPesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'namaBarang' => [
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
            'tanggalPakai' => [
                'type'       => 'DATE'
            ],
            'waktuPakai' => [
                'type'       => 'TIME',
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
        $this->forge->createTable('daftarPesanan');
    }

    public function down()
    {
        $this->forge->dropTable('daftarPesanan');
    }
}
