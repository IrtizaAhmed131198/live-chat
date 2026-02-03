<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'sender', 'message'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'sender');
    }
}
