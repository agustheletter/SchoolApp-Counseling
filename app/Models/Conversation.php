<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'last_message_at'
    ];

    protected $dates = ['last_message_at'];
    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->withDefault();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->withDefault();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function getOtherUserAttribute()
    {
        return $this->sender_id === auth()->id() ? $this->receiver : $this->sender;
    }
}