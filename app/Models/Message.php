<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'read_at'
    ];

    protected $dates = ['read_at'];
    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    // More efficient receiver relationship
    public function getReceiverAttribute()
    {
        // Check if receiver is already cached
        if (isset($this->attributes['receiver_cache'])) {
            return json_decode($this->attributes['receiver_cache'], true);
        }
        
        if (!$this->relationLoaded('conversation')) {
            $this->load('conversation');
        }
        
        $conversation = $this->conversation;
        if (!$conversation) {
            return null;
        }
        
        $receiverId = $conversation->sender_id === $this->sender_id 
            ? $conversation->receiver_id 
            : $conversation->sender_id;
            
        $receiver = User::select('id', 'nama')->find($receiverId);
        
        // Cache the result to avoid repeated queries
        $this->attributes['receiver_cache'] = json_encode($receiver);
        
        return $receiver;
    }
    
    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
    
    // Scope for messages by user
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('conversation', function($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        });
    }
}