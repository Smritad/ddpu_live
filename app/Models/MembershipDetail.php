<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipDetail extends Model
{
    protected $table = 'membership_details';

    protected $fillable = [
        'banner_image',
        'title',
        'items',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
