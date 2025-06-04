<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversationId;
    public $readByUserId;
    public $markedCount;

    public function __construct($conversationId, $readByUserId, $markedCount = 0)
    {
        $this->conversationId = $conversationId;
        $this->readByUserId = $readByUserId;
        $this->markedCount = $markedCount;
    }

    public function broadcastOn()
    {
        // Broadcast to the conversation participants
        $conversation = \App\Models\Conversation::find($this->conversationId);
        
        if (!$conversation) {
            return [];
        }
        
        return [
            new PrivateChannel('user.' . $conversation->sender_id),
            new PrivateChannel('user.' . $conversation->receiver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'message.read';
    }

    public function broadcastWith()
    {
        return [
            'conversation_id' => $this->conversationId,
            'read_by_user_id' => $this->readByUserId,
            'marked_count' => $this->markedCount,
            'timestamp' => now()->toISOString()
        ];
    }
}