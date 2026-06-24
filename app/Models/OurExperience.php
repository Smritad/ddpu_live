<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OurExperience extends Model
{
    use SoftDeletes;

    protected $table = 'our_experiences';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'banner_image',
        'title',
        'team_title',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Dates
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Automatically set created_by & updated_by
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = Auth::id();
                $model->save();
            }
        });
    }

    /**
     * Relations (optional but recommended)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
