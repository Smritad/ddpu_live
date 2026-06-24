<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SomeOfOurPastCases extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'some_of_our_past_cases';

    protected $fillable = [
        'banner_image',
        'heading',
        'description',
        'titles',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'titles' => 'array', // JSON to array
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
