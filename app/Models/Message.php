<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'content'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function chat(): BelongsTo {
        return $this->belongsTo(Chat::class);
    }
}
