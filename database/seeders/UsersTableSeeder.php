<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Añadir usuario administrador
        DB::table('users')->insert([
            'name' => 'Admin Usuario',
            'email' => 'admin@test.com',
            'phone' => '1234567890',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Añadir médicos
        DB::table('users')->insert([
            'name' => 'Dr. Juan Pérez',
            'email' => 'juanperez@test.com',
            'phone' => '9876543210',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);



        DB::table('users')->insert([
            'name' => 'Dr. Carlos Ramírez',
            'email' => 'carlosramirez@test.com',
            'phone' => '0987654321',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
