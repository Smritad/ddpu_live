<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatIsDdpu extends Model
{
    use SoftDeletes;

    protected $table = 'what_is_ddpus';

    protected $fillable = [
        'title',
        'banner_image',
        'gallery_images',
        'professional_description',
        'compare_description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    /* ==========================
        Relationships (Optional)
    ========================== */

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
