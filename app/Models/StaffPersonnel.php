<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class StaffPersonnel extends Model
{
    use HasFactory, SoftDeletes;

    // Table name (optional if default is 'staff_personnels')
    protected $table = 'staff_personnel';

    // Fillable fields
    protected $fillable = [
        'name',
        'slu',
        'designation',
        'title',
        'description',
        'banner_image',
        'profile_image',
        'social_links',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Dates
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
// Tell Laravel to auto-decode JSON
    protected $casts = [
        'social_links' => 'array',
    ];
    
    
    /**
     * Boot method to automatically fill created_by / updated_by
     */
    protected static function boot()
    {
        parent::boot();

        // When creating a record
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        // When updating a record
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
