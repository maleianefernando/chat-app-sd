<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $fillable = [
        'is_group',
        'name',
        'created_by'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
