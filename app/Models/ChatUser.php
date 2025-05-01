<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChatUser extends Model
{
    protected $fillable = [
        'user_id',
        'chat_id'
    ];
    protected $table = 'chat_user';
    // public function users(): BelongsToMany {
    //     return $this->belongsToMany(User::class);
    // }

    // public function chats(): BelongsToMany {
    //     return $this->belongsToMany(Chat::class);
    // }
}
