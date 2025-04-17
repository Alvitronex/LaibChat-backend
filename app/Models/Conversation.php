<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    // En app/Models/Conversation.php
    protected $with = ['users']; // Cargar automáticamente la relación users
    protected $appends = ['last_message']; // Añadir last_message a la serialización

    // Método para obtener el último mensaje
    public function getLastMessageAttribute()
    {
        return $this->messages()->with('user')->latest()->first();
    }
    protected $fillable = ['name', 'is_group'];

    /**
     * Obtener usuarios que pertenecen a esta conversación.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->withTimestamps();
    }

    /**
     * Obtener mensajes de esta conversación.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
