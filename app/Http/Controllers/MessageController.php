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
        try {
            $user = Auth::user();
            
            // Get all conversations for the current user
            $conversations = Conversation::where('sender_id', $user->id)
                                  ->orWhere('receiver_id', $user->id)
                                  ->get();

            // Get IDs of users who are already in conversations with the current user
            $contactIds = $conversations->map(function($conv) use ($user) {
                return $conv->sender_id === $user->id ? $conv->receiver_id : $conv->sender_id;
            });

            // Get contacts who are in conversations
            $contacts = User::where('id', '!=', $user->id)
                           ->whereIn('id', $contactIds) // Only users with existing conversations
                           ->select('id', 'nama', 'role')
                           ->get()
                           ->map(function($contact) use ($conversations) {
                               $conversation = $conversations->first(function($conv) use ($contact) {
                                   return $conv->sender_id === $contact->id || $conv->receiver_id === $contact->id;
                               });

                               return [
                                   'id' => $contact->id,
                                   'nama' => $contact->nama,
                                   'role' => $contact->role,
                                   'conversation_id' => $conversation ? $conversation->id : null
                               ];
                           });

            return response()->json([
                'success' => true,
                'contacts' => $contacts
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching contacts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load contacts'
            ], 500);
        }
    }

    public function availableContacts(Request $request)
    {
        try {
            $user = Auth::user();
            $search = $request->input('search', '');
            
            // Debug: Log the request details
            \Log::info('Available contacts request', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'search_term' => $search
            ]);

            // Base query - only exclude current user and soft-deleted users
            $query = User::where('id', '!=', $user->id)  // This ensures current user is excluded
                        ->whereNull('deleted_at');

            // Add search filter if provided
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('username', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            // Get results with pagination
            $contacts = $query->select('id', 'nama', 'role', 'username', 'email')
                             ->orderBy('nama')
                             ->limit(50)
                             ->get();

            // Format for Select2
            $formattedContacts = $contacts->map(function($contact) {
                return [
                    'id' => $contact->id,
                    'text' => "{$contact->nama} ({$contact->role})",
                    'nama' => $contact->nama,
                    'role' => ucfirst($contact->role),
                    'username' => $contact->username
                ];
            });

            return response()->json([
                'success' => true,
                'contacts' => $formattedContacts,
                'total' => $formattedContacts->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching available contacts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load available contacts'
            ], 500);
        }
    }

    public function show(Conversation $conversation)
    {
        try {
            // Authorization is now handled by the policy
            $user = auth()->user();
            
            // Get the other user in the conversation
            $otherUser = $conversation->sender_id === $user->id ? 
                        $conversation->receiver : 
                        $conversation->sender;

            // Get messages
            $messages = $conversation->messages()
                                   ->orderBy('created_at')
                                   ->get()
                                   ->map(function($message) {
                                       return [
                                           'id' => $message->id,
                                           'content' => $message->content,
                                           'sender_id' => $message->sender_id,
                                           'created_at' => $message->created_at
                                       ];
                                   });

            return response()->json([
                'success' => true,
                'conversation' => [
                    'id' => $conversation->id,
                    'other_user_name' => $otherUser->nama,
                    'other_user_role' => $otherUser->role
                ],
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            \Log::error('Error showing conversation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load conversation'
            ], 500);
        }
    }

    public function startConversation(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:tbl_users,id'  // Changed from users to tbl_users
            ]);

            // Check for existing conversation
            $conversation = Conversation::where(function($query) use ($validated) {
                $query->where([
                    ['sender_id', Auth::id()],
                    ['receiver_id', $validated['user_id']]
                ])->orWhere([
                    ['sender_id', $validated['user_id']],
                    ['receiver_id', Auth::id()]
                ]);
            })->first();

            if (!$conversation) {
                $conversation = Conversation::create([
                    'sender_id' => Auth::id(),
                    'receiver_id' => $validated['user_id'],
                    'last_message_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'conversation' => $conversation->load(['sender:id,nama', 'receiver:id,nama'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Start conversation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to start conversation'
            ], 500);
        }
    }

    public function send(Request $request, Conversation $conversation)
    {
        try {
            if ($conversation->sender_id !== auth()->id() && $conversation->receiver_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => auth()->id(),
                'content' => $request->content
            ]);

            $conversation->update(['last_message_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Send message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message'
            ], 500);
        }
    }

    public function sendMessage(Request $request, $conversationId)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string'
            ]);

            $message = Message::create([
                'conversation_id' => $conversationId,
                'sender_id' => Auth::id(),
                'content' => $validated['content']
            ]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage());
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