<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $isProduction = ENVIRONMENT === 'production';
        $username = (string) env('pos.adminUsername', $isProduction ? '' : 'admin');
        $password = (string) env('pos.adminPassword', $isProduction ? '' : 'password');
        $fullName = (string) env('pos.adminFullName', 'Xander/Elijah Administrator');

        if ($isProduction && ($username === '' || strlen($password) < 12)) {
            throw new \RuntimeException('Set pos.adminUsername and a unique pos.adminPassword of at least 12 characters in .env before seeding production.');
        }

        $this->db->table('users')->insert([
            'username' => $username,
            'full_name' => $fullName,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => $now,
        ]);

        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Maria Santos', 'email' => 'maria.santos@example.com', 'phone' => '09171234567', 'created_at' => $now],
            ['full_name' => 'Juan Dela Cruz', 'email' => 'juan.delacruz@example.com', 'phone' => '09182345678', 'created_at' => $now],
            ['full_name' => 'Angela Reyes', 'email' => 'angela.reyes@example.com', 'phone' => '09193456789', 'created_at' => $now],
        ]);

        $this->db->table('products')->insertBatch([
            ['name' => 'Classic White Tee', 'price' => '499.00', 'stock_quantity' => 28, 'created_at' => $now],
            ['name' => 'Everyday Tote Bag', 'price' => '349.50', 'stock_quantity' => 16, 'created_at' => $now],
            ['name' => 'Canvas Notebook', 'price' => '179.00', 'stock_quantity' => 42, 'created_at' => $now],
            ['name' => 'Ceramic Coffee Mug', 'price' => '259.00', 'stock_quantity' => 12, 'created_at' => $now],
        ]);
    }
}
