<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Broadcast to both participants of the conversation
        $conversation = $this->message->conversation;
        
        return [
            new PrivateChannel('messages.' . $conversation->sender_id),
            new PrivateChannel('messages.' . $conversation->receiver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'NewMessageReceived';
    }

    public function broadcastWith()
    {
        // Load the conversation if not already loaded
        if (!$this->message->relationLoaded('conversation')) {
            $this->message->load('conversation');
        }

        // Get receiver info
        $conversation = $this->message->conversation;
        $receiverId = $conversation->sender_id === $this->message->sender_id 
            ? $conversation->receiver_id 
            : $conversation->sender_id;
        
        // Load receiver data
        $receiver = \App\Models\User::select('id', 'nama')->find($receiverId);

        return [
            'id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'content' => $this->message->content,
            'created_at' => $this->message->created_at->toISOString(),
            'sender_name' => $this->message->sender->nama ?? 'Unknown',
            'receiver' => $receiver,
            'conversation' => [
                'id' => $conversation->id,
                'sender_id' => $conversation->sender_id,
                'receiver_id' => $conversation->receiver_id,
                'last_message_at' => $conversation->last_message_at->toISOString(),
            ]
        ];
    }
}