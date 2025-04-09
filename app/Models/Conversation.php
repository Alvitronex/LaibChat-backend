<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

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
