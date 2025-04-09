<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal para las conversaciones
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    // Verificar que el usuario pertenezca a la conversación
    return $user->conversations()->where('conversations.id', $conversationId)->exists();
});
