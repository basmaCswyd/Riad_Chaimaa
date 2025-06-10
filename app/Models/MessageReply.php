<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'user_id',
        'body',
    ];

    // RELATION : Une réponse appartient à un ticket
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    // RELATION : Une réponse appartient à un utilisateur (son auteur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}