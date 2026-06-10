<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $table = 'form_submissions';

    protected $fillable = [
        'brand_id',
        'page_url',
        'form_action',
        'form_method',
        'form_data',
        'meta',
    ];

    protected $casts = [
        'form_data' => 'array',
        'meta' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
