<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineMessage extends Model
{
    protected $fillable = [
        'brand_id','name','email','message'
    ];
}
