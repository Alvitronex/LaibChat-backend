<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Mario Alvarado',
            'email' => 'mario440@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('12345678')
        ]);

        // Añadir médicos especialistas
        User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'juanperez@test.com',
            'phone' => '9876543210',
            'password' => bcrypt('password123')
        ]);



        User::create([
            'name' => 'Dr. Carlos Ramírez',
            'email' => 'carlosramirez@test.com',
            'phone' => '0987654321',
            'password' => bcrypt('password123')
        ]);
    }
}
