<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ✅ Import SoftDeletes

class GeneralPracticeDetails extends Model
{
    use SoftDeletes; // ✅ Add SoftDeletes trait

    protected $table = 'general_practice_details';

    protected $fillable = [
        'banner_image',
        'main_image',
        'description',
        'benefits_heading',
        'benefits_description',
        'items',
        'created_by'
    ];

    // Cast `items` JSON column to array automatically
    protected $casts = [
        'items' => 'array',
    ];

    // SoftDeletes requires deleted_at column
    protected $dates = ['deleted_at'];
}
