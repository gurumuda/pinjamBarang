<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email' => 'admin@admin.com',
            'pass' => '$2y$10$QVvjgFGdNELuJIggL3IO0.BLqhWXvAw8keQP49yhzYWgYO/BPOj5O',
            'nama' => 'Administrator',

        ];

        $this->db->table('pengguna')->insert($data);
    }
}