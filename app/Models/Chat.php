<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    protected $fillable = [
        'is_group',
        'name',
        'created_by'
    ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function messages(): hasMany {
        return $this->hasMany(Message::class);
    }

    // public function chatUser(): BelongsToMany {
    //     return $this->belongsToMany(ChatUser::class);
    // }
}
