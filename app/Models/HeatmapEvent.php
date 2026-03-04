<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeatmapEvent extends Model
{
    protected $fillable = [
        'brand_id','session_id','url',
        'type','x','y','scroll_percent'
    ];
}
