<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurMethod extends Model
{
    use HasFactory;

    protected $table = 'our_methods';

    protected $fillable = [
        'banner_image',
        'strategic_title',
        'strategic_elements_title',
        'strategic_image',
        'strategic_description',
        'elements',
        'created_by',
        'deleted_by',
        'updated_by',

        
        ];

    // Cast elements column as JSON automatically
    protected $casts = [
        'elements' => 'array',
    ];
}
