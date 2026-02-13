<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandUser extends Model
{
    protected $table = 'brand_users';

    protected $fillable = [
        'brand_id',
        'user_id'
    ];

    protected $casts = [
        'brand_id' => 'string',
        'user_id' => 'string',
    ];

    // Relationship with Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
