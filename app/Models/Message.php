<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $fillable = ['chat_id', 'sender', 'message', 'is_read'];

    protected $appends = ['formatted_created_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'sender');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->format('h:i A, M d, Y')
            : null;
    }
}
