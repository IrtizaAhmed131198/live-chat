<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['website_id', 'session_id', 'last_url'];

    public function user()
    {
        return $this->hasOne(User::class, 'visitor_id', 'id');
    }
}
