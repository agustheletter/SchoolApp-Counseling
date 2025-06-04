<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Events\NewMessageReceived;

class MessageController extends Controller
{
    public function index()
    {
        // Fixed: Load messages relationship to match Blade template expectations
        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with([
                'sender:id,nama', 
                'receiver:id,nama', 
                'messages' => function($query) {
                    $query->latest()->limit(1); // Get last message for preview
                }
            ])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('counseling.messages', compact('conversations'));
    }

    public function contacts()
    {
        // Cache contacts for better performance
        $cacheKey = 'contacts_' . Auth::id();
        
        $users = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return User::where('id', '!=', Auth::id())
                      ->select('id', 'nama', 'role')
                      ->orderBy('nama')
                      ->get();
        });
                    
        return response()->json([
            'success' => true,
            'contacts' => $users
        ]);
    }

    public function show(Conversation $conversation)
    {
        if (!$this->canAccessConversation($conversation)) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        // Load messages with sender info
        $messages = $conversation->messages()
            ->with(['sender:id,nama'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Load conversation relationships
        $conversation->load(['sender:id,nama', 'receiver:id,nama']);

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }

    public function startConversation(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $request->validate([
                'receiver_id' => 'required|exists:users,id|different:' . Auth::id()
            ]);

            $receiverId = $request->receiver_id;
            $senderId = Auth::id();

            // Check for existing conversation
            $conversation = Conversation::where(function($query) use ($senderId, $receiverId) {
                $query->where([
                    ['sender_id', $senderId],
                    ['receiver_id', $receiverId]
                ])->orWhere([
                    ['sender_id', $receiverId],
                    ['receiver_id', $senderId]
                ]);
            })->first();

            // If conversation doesn't exist, create it
            if (!$conversation) {
                $conversation = Conversation::create([
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'last_message_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'conversation' => $conversation->load(['sender:id,nama', 'receiver:id,nama']),
                'message' => 'Conversation started successfully'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Start conversation error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'receiver_id' => $request->receiver_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to start conversation'
            ], 500);
        }
    }

    public function send(Request $request, Conversation $conversation)
    {
        DB::beginTransaction();
        
        try {
            if (!$this->canAccessConversation($conversation)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized'
                ], 403);
            }

            $request->validate([
                'content' => 'required|string|max:1000'
            ]);

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'content' => trim($request->content)
            ]);

            // Update conversation's last_message_at
            $conversation->update(['last_message_at' => now()]);

            // Load relationships for broadcasting
            $message->load(['sender:id,nama', 'conversation']);
            
            DB::commit();

            // Broadcast the message after successful commit
            try {
                broadcast(new NewMessageReceived($message))->toOthers();
            } catch (\Exception $e) {
                \Log::warning('Broadcasting failed: ' . $e->getMessage());
                // Don't fail the request if broadcasting fails
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Message send error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'conversation_id' => $conversation->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to send message'
            ], 500);
        }
    }

    public function checkNew()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }
            
            // Get unread message count
            $unreadCount = Message::whereHas('conversation', function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();

            // Get conversations with unread messages
            $unreadConversations = Conversation::where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->whereHas('messages', function($query) use ($user) {
                $query->where('sender_id', '!=', $user->id)
                      ->whereNull('read_at');
            })
            ->pluck('id');

            return response()->json([
                'success' => true,
                'unreadCount' => $unreadCount,
                'unreadConversations' => $unreadConversations
            ]);
        } catch (\Exception $e) {
            \Log::error('Check new messages error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to check messages'
            ], 500);
        }
    }

    public function markAsRead(Conversation $conversation)
    {
        try {
            if (!$this->canAccessConversation($conversation)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized'
                ], 403);
            }

            // Mark messages as read where current user is the receiver
            $updatedCount = Message::where('conversation_id', $conversation->id)
                  ->where('sender_id', '!=', Auth::id())
                  ->whereNull('read_at')
                  ->update(['read_at' => now()]);

            // Broadcast the read event if messages were marked
            if ($updatedCount > 0 && class_exists('\App\Events\MessageRead')) {
                try {
                    broadcast(new \App\Events\MessageRead($conversation->id, Auth::id(), $updatedCount))->toOthers();
                } catch (\Exception $e) {
                    \Log::warning('Broadcasting read status failed: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'marked_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Mark as read error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'conversation_id' => $conversation->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to mark messages as read'
            ], 500);
        }
    }

    private function canAccessConversation(Conversation $conversation)
    {
        return $conversation->sender_id === Auth::id() || 
               $conversation->receiver_id === Auth::id();
    }
}