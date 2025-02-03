<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;
    public $user;

    // Constructeur pour initialiser le message et l'utilisateur
    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    // Diffuser l'événement sur le canal chat-channel
    public function broadcastOn()
    {
        return new Channel('chat-channel');
    }

    // Personnaliser le nom de l'événement
    // public function broadcastAs()
    // {
    //     return 'message.sent';
    // }
}
