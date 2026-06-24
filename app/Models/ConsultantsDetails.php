<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultantsDetails extends Model
{
    use HasFactory, SoftDeletes; // ✅ Add SoftDeletes trait

    protected $table = 'consultants_details';

    protected $fillable = [
        'banner_image',
        'heading',
        'details',      // JSON column for multiple title+description
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Cast `details` JSON column to array automatically
    protected $casts = [
        'details' => 'array',
    ];

    // SoftDeletes requires `deleted_at` column
    protected $dates = ['deleted_at'];
}
