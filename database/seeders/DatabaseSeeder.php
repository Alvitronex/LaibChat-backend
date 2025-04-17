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
        $conversation = \App\Models\Conversation::create([
            'name' => 'Chat de prueba',
            'is_group' => false
        ]);

        // Asociar usuarios a la conversación
        $conversation->users()->attach([1, 2]); // Asociar los usuarios con ID 1 y 2

        // Crear mensajes de ejemplo
        \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => 1,
            'content' => '¡Hola! ¿Cómo estás?',
            'read' => true
        ]);

        \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => 2,
            'content' => 'Muy bien, ¿y tú?',
            'read' => true
        ]);

        \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => 1,
            'content' => 'También, gracias. ¿Listo para la reunión?',
            'read' => true
        ]);

        \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => 2,
            'content' => 'Sí, en unos minutos me conecto',
            'read' => false
        ]);
    }
}
