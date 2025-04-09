<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Obtener todas las conversaciones del usuario autenticado
     */
    public function getConversations()
    {
        $user = Auth::user();
        $conversations = $user->conversations()->with('users')->get();
        return response()->json($conversations);
    }

    /**
     * Obtener todos los mensajes de una conversación específica
     */
    public function getMessages($conversationId)
    {
        $user = Auth::user();
        
        // Verificar que el usuario pertenezca a la conversación
        $conversation = $user->conversations()->findOrFail($conversationId);
        
        // Obtener mensajes con información del usuario que envió cada mensaje
        $messages = $conversation->messages()->with('user')->orderBy('created_at', 'asc')->get();
        
        return response()->json($messages);
    }

    /**
     * Enviar un mensaje a una conversación
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $user = Auth::user();
        
        // Validar la petición
        $request->validate([
            'content' => 'required|string',
        ]);
        
        // Verificar que el usuario pertenezca a la conversación
        $conversation = $user->conversations()->findOrFail($conversationId);
        
        // Crear el mensaje
        $message = Message::create([
            'conversation_id' => $conversationId,
            'user_id' => $user->id,
            'content' => $request->content,
            'read' => false
        ]);
        
        // Cargar relación de usuario para incluirla en el broadcast
        $message->load('user');
        
        // Disparar evento de broadcasting
        broadcast(new MessageSent($message))->toOthers();
        
        return response()->json($message);
    }

    /**
     * Obtener usuarios disponibles para conversar
     */
    public function getAvailableUsers()
    {
        $user = Auth::user();
        // Solo obtenemos usuarios con nombres válidos (no dfdf)
        $users = User::where('id', '!=', $user->id)
            ->where('name', '!=', 'dfdf')
            ->whereRaw("name NOT LIKE '%dfdf%'")
            ->get();
            
        // Log para debugging
        \Log::info('Users fetched: ' . $users->count());
        \Log::info('Users data: ' . json_encode($users));
            
        return response()->json($users);
    }

    /**
     * Crear una nueva conversación
     */
    public function createConversation(Request $request)
    {
        $user = Auth::user();
        
        // Validar la petición
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'name' => 'nullable|string',
            'is_group' => 'boolean'
        ]);
        
        // Verificar que al menos haya otro usuario además del creador
        if (empty($request->user_ids)) {
            return response()->json(['error' => 'Debe seleccionar al menos un usuario para la conversación'], 422);
        }
        
        // Agregar al usuario actual a la lista de participantes
        $userIds = array_unique(array_merge($request->user_ids, [$user->id]));
        
        // Determinar si es grupo o no
        $isGroup = $request->is_group ?? (count($userIds) > 2);
        
        // Si no es grupo y hay solo dos usuarios, verificar si ya existe una conversación entre ellos
        if (!$isGroup && count($userIds) == 2) {
            $otherUserId = $userIds[0] == $user->id ? $userIds[1] : $userIds[0];
            
            // Buscar conversaciones existentes
            $existingConversation = $user->conversations()
                ->where('is_group', false)
                ->whereHas('users', function ($query) use ($otherUserId) {
                    $query->where('users.id', $otherUserId);
                })
                ->first();
            
            if ($existingConversation) {
                return response()->json([
                    'message' => 'Ya existe una conversación con este usuario',
                    'conversation' => $existingConversation->load('users')
                ]);
            }
        }
        
        // Crear la conversación
        $conversation = Conversation::create([
            'name' => $request->name,
            'is_group' => $isGroup
        ]);
        
        // Asociar usuarios a la conversación
        $conversation->users()->attach($userIds);
        
        // Crear mensaje inicial si existe contenido
        if ($request->has('initial_message')) {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'content' => $request->initial_message,
                'read' => false
            ]);
            
            // Si hay mensaje inicial, enviarlo por broadcasting
            $message->load('user');
            broadcast(new MessageSent($message))->toOthers();
        }
        
        return response()->json([
            'message' => 'Conversación creada exitosamente',
            'conversation' => $conversation->load('users')
        ]);
    }
}
