<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['brand_id', 'session_id', 'last_url', 'ip_address', 'country', 'city', 'device', 'browser', 'os'];

    protected static function boot()
    {
        parent::boot();

        // Delete associated users when visitor is deleted
        static::deleting(function ($visitor) {
            $visitor->users()->delete();
        });
    }

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
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
