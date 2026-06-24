<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DentistsDetails extends Model
{
    use SoftDeletes;

    protected $table = 'dentists_details';

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
