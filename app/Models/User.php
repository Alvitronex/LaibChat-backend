<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone' => 'string', // Añade esta línea para asegurar que phone se maneje como string

        'email_verified_at' => 'datetime',

        'password' => 'hashed',
    ];

    /**
     * Obtener todas las conversaciones a las que pertenece el usuario.
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
            ->withTimestamps();
    }

    /**
     * Obtener todos los mensajes enviados por el usuario.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
