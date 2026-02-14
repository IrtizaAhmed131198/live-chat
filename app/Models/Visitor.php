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

    /**
     * Relationship with Users (PLURAL - agar multiple users ho)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'visitor_id', 'id');
    }

    /**
     * Relationship with Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id', 'id');
    }
}
