<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToMessagingTables extends Migration
{
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            // Composite index for finding conversations by participants
            $table->index(['sender_id', 'receiver_id'], 'conversations_participants_index');
            $table->index(['receiver_id', 'sender_id'], 'conversations_participants_reverse_index');
            
            // Index for ordering by last message
            $table->index('last_message_at');
        });

        Schema::table('messages', function (Blueprint $table) {
            // Index for conversation messages
            $table->index(['conversation_id', 'created_at'], 'messages_conversation_time_index');
            
            // Index for unread messages queries
            $table->index(['sender_id', 'read_at'], 'messages_sender_read_index');
            
            // Index for checking unread messages by conversation
            $table->index(['conversation_id', 'sender_id', 'read_at'], 'messages_unread_by_conversation_index');
        });
    }

    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropIndex('conversations_participants_index');
            $table->dropIndex('conversations_participants_reverse_index');
            $table->dropIndex(['last_message_at']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('messages_conversation_time_index');
            $table->dropIndex('messages_sender_read_index');
            $table->dropIndex('messages_unread_by_conversation_index');
        });
    }
}