<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Conversation $conversation)
    {
        return $conversation->sender_id === $user->id || 
               $conversation->receiver_id === $user->id;
    }
}
