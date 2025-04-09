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
            'password' => bcrypt('12345678')
        ]);
        
        // Añadir médicos especialistas
        User::create([
            'name' => 'Dr. Juan Pérez',
            'email' => 'juanperez@test.com',
            'password' => bcrypt('password123')
        ]);
        
        User::create([
            'name' => 'Dra. María López',
            'email' => 'marialopez@test.com',
            'password' => bcrypt('password123')
        ]);
        
        User::create([
            'name' => 'Dr. Carlos Ramírez',
            'email' => 'carlosramirez@test.com',
            'password' => bcrypt('password123')
        ]);
    }
}
