<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;  // Assure-toi d'importer Auth
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validation du message
        $request->validate([
            'message' => 'required|string|max:255'
        ]);

        // Vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $user = auth()->user();
        $message = $request->input('message');

        // Ajout de logs pour déboguer
        Log::info('Message envoyé par', ['user' => $user->name, 'message' => $message]);

        // Diffuser l'événement
        broadcast(new MessageSent($message, $user))->toOthers();

        return response()->json(['status' => 'Message envoyé']);
    }
    public function getMessages()
    {
        $messages = Message::with('user')->latest()->take(50)->get();
        return response()->json($messages);
    }
}
