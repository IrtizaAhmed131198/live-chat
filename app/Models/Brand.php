<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $fillable = ['name', 'user_id', 'url', 'logo', 'email', 'phone', 'address', 'status', 'logo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
