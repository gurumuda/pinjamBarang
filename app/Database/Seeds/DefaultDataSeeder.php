<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'admin@admin.com',
                'pass' => '$2y$10$QVvjgFGdNELuJIggL3IO0.BLqhWXvAw8keQP49yhzYWgYO/BPOj5O',
                'nama' => 'Administrator',
                'level' => '2'
            ],
            [
                'email' => 'guru1@admin.com',
                'pass' => '$2y$10$QVvjgFGdNELuJIggL3IO0.BLqhWXvAw8keQP49yhzYWgYO/BPOj5O',
                'nama' => 'Alvian',
                'level' => '1'
            ]
        ];

        $this->db->table('pengguna')->insertBatch($data);

        $dataInstansi = [
            'namaInstansi' => 'SMAN 1 Jorong',
            'alamat' => 'Jl A Yani Km 96 Jorong Kab. Tanah Laut'
        ];

        $this->db->table('instansi')->insert($dataInstansi);
    }
}
