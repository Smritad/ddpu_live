<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForNonMembershipDetails extends Model
{
    use SoftDeletes;

    protected $table = 'for_non_membership_details';

    protected $fillable = [
        'banner_image',
        'main_image',
        'heading',
        'description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];
}
