<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['visitor_id', 'website_id', 'agent_id', 'status', 'closed_reason', 'last_visitor_activity_at', 'last_agent_activity_at', 'warned_at',
        'system_message_at', 'closed_at', 'agent_warned', 'system_notified'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->hasOne(User::class, 'id', 'agent_id');
    }

    public function visitor()
    {
        return $this->hasOne(User::class, 'visitor_id', 'visitor_id');
    }

    public function get_visitor()
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }
}
