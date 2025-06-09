<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the conversation.
     */
    public function view(User $user, Conversation $conversation)
    {
        return $conversation->sender_id === $user->id || 
               $conversation->receiver_id === $user->id;
    }

    /**
     * Determine whether the user can send messages in the conversation.
     */
    public function send(User $user, Conversation $conversation)
    {
        return $this->view($user, $conversation);
    }

    /**
     * Determine whether the user can mark messages as read in the conversation.
     */
    public function markAsRead(User $user, Conversation $conversation)
    {
        return $this->view($user, $conversation);
    }
}