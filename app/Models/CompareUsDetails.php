<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompareUsDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compare_us_details';

    protected $fillable = [
        'banner_image',
        'heading',
        'details',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // 👇 Cast JSON column automatically to array
    protected $casts = [
        'details' => 'array',
    ];

    // 👇 Soft delete column
    protected $dates = ['deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | Optional: Relationships (if you have users table)
    |--------------------------------------------------------------------------
    */

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'deleted_by');
    }
}
