<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'subject',
        'is_closed',
    ];

    // RELATION : Un ticket de message appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELATION : Un ticket a plusieurs réponses
    public function replies()
    {
        return $this->hasMany(MessageReply::class);
    }
}