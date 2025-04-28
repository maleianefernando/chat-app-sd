<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_id',
        'content'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
