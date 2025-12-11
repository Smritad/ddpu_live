<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipApplicationform extends Model
{
    use HasFactory;

    protected $table = 'membership_applicationforms';

    protected $fillable = [
        'step1', 'step2', 'step3', 'step4', 'step5', 'step6', 'step7',
        'final_status',
        'submitted_at',
    ];

    protected $casts = [
        'step1' => 'array',
        'step2' => 'array',
        'step3' => 'array',
        'step4' => 'array',
        'step5' => 'array',
        'step6' => 'array',
        'step7' => 'array',
        'final_status' => 'boolean',
        'submitted_at' => 'datetime',
    ];
}
