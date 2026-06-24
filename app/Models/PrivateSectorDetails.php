<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateSectorDetails extends Model
{
    use SoftDeletes;

    protected $table = 'private_sector_academic_details';

    protected $fillable = [
        'banner_image',
        'main_image',
        'heading',
        'description',
        'academic_heading',
        'academic_description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
