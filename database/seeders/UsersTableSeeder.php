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
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Añadir médicos
        DB::table('users')->insert([
            'name' => 'Dr. Juan Pérez',
            'email' => 'juanperez@test.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'name' => 'Dra. María López',
            'email' => 'marialopez@test.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'name' => 'Dr. Carlos Ramírez',
            'email' => 'carlosramirez@test.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}